<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

namespace Modules\LabTrack\Controller;

use Alxarafe\Infrastructure\Http\Controller\ViewController;
use Alxarafe\Infrastructure\Lib\Functions;
use Alxarafe\Infrastructure\Lib\Trans;
use Alxarafe\Application\Bus\SimpleCommandBus;
use Modules\LabTrack\Application\AppContainer;
use Modules\LabTrack\Application\Bus\Command\RecordMovementCommand;
use Modules\LabTrack\Domain\Port\Driven\WorkOrderRepositoryInterface;
use Modules\LabTrack\Model\Operator;
use Modules\LabTrack\Model\CostCenter;
use Modules\LabTrack\Model\Family;
use Modules\LabTrack\Model\Process;

class MainController extends ViewController
{
    private SimpleCommandBus $commandBus;
    private WorkOrderRepositoryInterface $orderRepository;

    public function __construct()
    {
        parent::__construct();

        $container = AppContainer::get();
        $this->commandBus = $container->get(SimpleCommandBus::class);
        $this->orderRepository = $container->get(WorkOrderRepositoryInterface::class);
    }

    /**
     * Shows the PIN identification screen.
     */
    public function doIndex(): bool
    {
        if (isset($_SESSION['labtrack']['operator_id'])) {
            Functions::httpRedirect($this::url('selectOrder'));
            return true;
        }

        $this->addVariables([
            'title' => Trans::_('station_identification'),
        ]);
        $this->setDefaultTemplate('labtrack/station/login');
        return true;
    }

    /**
     * Validates Operator PIN.
     */
    public function doLogin(): bool
    {
        $pin = $_POST['pin'] ?? '';
        $operator = Operator::where('pin', $pin)->where('active', 1)->first();

        if (!$operator) {
            $this->addVariables(['error' => Trans::_('invalid_pin')]);
            return $this->doIndex();
        }

        $_SESSION['labtrack'] = [
            'operator_id' => $operator->id,
            'operator_name' => $operator->name,
        ];

        Functions::httpRedirect($this::url('selectOrder'));
        return true;
    }

    /**
     * Logs out the current operator.
     */
    public function doLogout(): bool
    {
        unset($_SESSION['labtrack']);
        Functions::httpRedirect($this::url('index'));
        return true;
    }

    /**
     * Selects an Order — uses Domain Repository for read.
     */
    public function doSelectOrder(): bool
    {
        $this->checkIdentification();

        $orders = $this->orderRepository->findRecent(20);

        $this->addVariables([
            'title' => Trans::_('select_order'),
            'orders' => $orders,
        ]);
        $this->setDefaultTemplate('labtrack/station/order');
        return true;
    }

    /**
     * Selects a Cost Center.
     */
    public function doSelectCenter(): bool
    {
        $this->checkIdentification();

        if (isset($_POST['order_id'])) {
            $_SESSION['labtrack']['order_id'] = (int)$_POST['order_id'];
        }

        if (!isset($_SESSION['labtrack']['order_id'])) {
            Functions::httpRedirect($this::url('selectOrder'));
            return true;
        }

        $centers = CostCenter::where('active', 1)->orderBy('sort_order')->get();

        $this->addVariables([
            'title' => Trans::_('select_center'),
            'centers' => $centers,
        ]);
        $this->setDefaultTemplate('labtrack/station/center');
        return true;
    }

    /**
     * Selects a Family.
     */
    public function doSelectFamily(): bool
    {
        $this->checkIdentification();
        $centerId = (int)($_GET['centerId'] ?? 0);
        $_SESSION['labtrack']['cost_center_id'] = $centerId;

        $families = Family::where('cost_center_id', $centerId)
            ->where('active', 1)
            ->orderBy('sort_order')
            ->get();

        $this->addVariables([
            'title' => Trans::_('select_family'),
            'families' => $families,
        ]);
        $this->setDefaultTemplate('labtrack/station/family');
        return true;
    }

    /**
     * Selects a Process.
     */
    public function doSelectProcess(): bool
    {
        $this->checkIdentification();
        $familyId = (int)($_GET['familyId'] ?? 0);
        $_SESSION['labtrack']['family_id'] = $familyId;

        $family = Family::find($familyId);
        $processes = $family->processes()->where('active', 1)->orderBy('sort_order')->get();

        $this->addVariables([
            'title' => Trans::_('select_process'),
            'processes' => $processes,
        ]);
        $this->setDefaultTemplate('labtrack/station/process');
        return true;
    }

    /**
     * Selects a Sequence.
     */
    public function doSelectSequence(): bool
    {
        $this->checkIdentification();
        $processId = (int)($_GET['processId'] ?? 0);
        $_SESSION['labtrack']['process_id'] = $processId;

        $process = Process::find($processId);
        $sequences = $process->sequences()->where('active', 1)->orderBy('sort_order')->get();

        $this->addVariables([
            'title' => Trans::_('select_sequence'),
            'sequences' => $sequences,
        ]);
        $this->setDefaultTemplate('labtrack/station/sequence');
        return true;
    }

    /**
     * Records the movement via Command Bus (hexagonal).
     */
    public function doRecord(): bool
    {
        $this->checkIdentification();

        $sequenceId = (int)($_POST['sequence_id'] ?? 0);
        $units = (int)($_POST['units'] ?? 1);
        $duration = (int)($_POST['duration'] ?? 0);

        $data = $_SESSION['labtrack'];

        $cmd = new RecordMovementCommand(
            operatorId: (int)$data['operator_id'],
            orderId: (int)$data['order_id'],
            costCenterId: (int)$data['cost_center_id'],
            familyId: (int)$data['family_id'],
            processId: (int)$data['process_id'],
            sequenceId: $sequenceId,
            units: $units,
            durationMinutes: $duration
        );

        $this->commandBus->dispatch($cmd);

        // Clear workflow but keep operator
        unset(
            $_SESSION['labtrack']['order_id'],
            $_SESSION['labtrack']['cost_center_id'],
            $_SESSION['labtrack']['family_id'],
            $_SESSION['labtrack']['process_id']
        );

        Functions::httpRedirect($this::url('selectOrder'));
        return true;
    }

    /**
     * Internal helper to ensure operator is identified.
     */
    private function checkIdentification(): void
    {
        if (!isset($_SESSION['labtrack']['operator_id'])) {
            Functions::httpRedirect($this::url('index'));
            exit;
        }
    }
}
