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

use Alxarafe\Attribute\Menu;
use Alxarafe\Infrastructure\Http\Controller\ResourceController;
use Alxarafe\Infrastructure\Lib\Messages;
use Alxarafe\Application\Bus\SimpleCommandBus;
use Modules\LabTrack\Application\AppContainer;
use Modules\LabTrack\Domain\Port\Driven\MovementRepositoryInterface;
use Modules\LabTrack\Domain\Port\Driven\WorkOrderRepositoryInterface;
use Modules\LabTrack\Application\Bus\Command\RecordMovementCommand;
use Modules\LabTrack\Application\Bus\Command\CreateOrderCommand;
use Modules\LabTrack\Domain\Model\WorkOrder;
use Modules\LabTrack\Model\CostCenter;
use Modules\LabTrack\Model\Family;
use Modules\LabTrack\Model\Process;
use Modules\LabTrack\Model\Sequence;
use Modules\LabTrack\Model\Movement as EloquentMovement;

#[Menu(
    menu: 'admin_sidebar',
    label: 'order_management',
    icon: 'fa-barcode',
    order: 20,
    permission: 'LabTrack.Order.index'
)]
/**
 * Controller for managing lab work orders.
 * Uses hexagonal architecture: Domain Ports + Command Bus for mutations,
 * Eloquent Models for read-only queries (CQRS light).
 */
class OrderController extends ResourceController
{
    #[\Override]
    protected function getModelClass(): string
    {
        return \Modules\LabTrack\Model\Order::class;
    }

    private MovementRepositoryInterface $movementRepository;
    private WorkOrderRepositoryInterface $orderRepository;
    private SimpleCommandBus $commandBus;

    public function __construct()
    {
        parent::__construct();

        $container = AppContainer::get();
        $this->movementRepository = $container->get(MovementRepositoryInterface::class);
        $this->orderRepository = $container->get(WorkOrderRepositoryInterface::class);
        $this->commandBus = $container->get(SimpleCommandBus::class);
    }

    #[\Override]
    protected function fetchListData(string $tabId): array
    {
        $orders = $this->orderRepository->findRecent(50);

        $data = [];
        foreach ($orders as $order) {
            $data[] = $order->toArray();
        }

        return ['total' => count($data), 'rows' => $data];
    }

    #[\Override]
    protected function fetchRecordData(): array
    {
        if ($this->recordId === 'new') {
            return ['name' => ''];
        }

        $order = $this->orderRepository->findById((int) $this->recordId);
        if (!$order) {
            return [];
        }

        // Add movements for the order detail view
        $movements = $this->movementRepository->findDetailedByOrderId((int) $this->recordId, true);

        $data = $order->toArray();
        $data['movements'] = $movements;

        return $data;
    }

    #[\Override]
    protected function saveRecord(): void
    {
        $data = $_POST['data'] ?? [];
        $name = $data['name'] ?? 'Sin nombre';

        if (!empty($this->recordId) && $this->recordId !== 'new') {
            // Update existing order
            $order = $this->orderRepository->findById((int) $this->recordId);
            if ($order) {
                $order->rename($name);
                $this->orderRepository->save($order);
                Messages::addMessage('Orden modificada con éxito.');
            }
        } else {
            // Create new order via Command Bus
            $cmd = new CreateOrderCommand($name);
            $this->commandBus->dispatch($cmd);
            Messages::addMessage('Orden creada con éxito.');
        }

        header('Location: ' . static::url());
        exit;
    }

    #[\Override]
    public function doDelete(): bool
    {
        if ($this->recordId && $this->recordId !== 'new') {
            // Check if order has movements before deleting
            $movements = $this->movementRepository->findByOrderId((int) $this->recordId);
            if (!empty($movements)) {
                Messages::addError('No se puede borrar una orden con movimientos registrados.');
                header('Location: ' . static::url());
                exit;
            }

            $this->orderRepository->delete((int) $this->recordId);
            Messages::addMessage('Orden borrada con éxito.');
        }

        header('Location: ' . static::url());
        exit;
        return true;
    }

    /**
     * Records a production movement via Command Bus.
     */
    public function doAddRecord(): bool
    {
        $data = $_POST;

        $cmd = new RecordMovementCommand(
            operatorId: (int) ($data['operator_id'] ?? \Alxarafe\Infrastructure\Auth\Auth::$user->id ?? 0),
            orderId: (int) ($data['order_id'] ?? 0),
            costCenterId: (int) ($data['center_id'] ?? 0),
            familyId: (int) ($data['family_id'] ?? 0),
            processId: (int) ($data['process_id'] ?? 0),
            sequenceId: (int) ($data['sequence_id'] ?? 0),
            units: (int) ($data['units'] ?? 1),
            durationMinutes: (int) ($data['duration'] ?? 0),
            repeated: (int) ($data['repeated'] ?? 0),
            notes: $data['notes'] ?? null
        );

        $this->commandBus->dispatch($cmd);
        Messages::addMessage('Movimiento registrado con éxito.');

        header('Location: ' . static::url('edit', ['id' => $cmd->orderId]));
        exit;
        return true;
    }

    #[\Override]
    protected function getListColumns(): array
    {
        return [
            'id',
            'name' => [
                'type' => 'text',
                'label' => 'Nombre',
            ],
        ];
    }

    #[\Override]
    protected function getEditFields(): array
    {
        return [
            'order_data' => [
                'label' => 'Datos de la Orden',
                'col' => 'col-md-6',
                'fields' => [
                    'id' => new \Alxarafe\Infrastructure\Component\Fields\Text('id', 'ID', ['readonly' => true]),
                    'name' => new \Alxarafe\Infrastructure\Component\Fields\Text('name', 'Nombre'),
                ],
            ],
        ];
    }

    #[\Override]
    protected function beforeEdit(): void
    {
        if ($this->recordId && $this->recordId !== 'new') {
            $data = $this->fetchRecordData();
            $this->addVariable('data', $data);

            // Provide drill-down data for the order edit view
            $centers = CostCenter::where('active', 1)->orderBy('sort_order')->get();
            $this->addVariable('centers', $centers);
        } elseif ($this->recordId === 'new') {
            $this->addVariable('data', ['name' => '']);
        }
    }
}
