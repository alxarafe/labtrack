<?php

declare(strict_types=1);

namespace Modules\LabTrack\Controller;

use Alxarafe\Base\Controller\ViewController;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Trans;
use Modules\LabTrack\Model\Operator;
use Modules\LabTrack\Model\Order;
use Modules\LabTrack\Model\CostCenter;
use Modules\LabTrack\Model\Family;
use Modules\LabTrack\Model\Process;
use Modules\LabTrack\Model\Sequence;
use Modules\LabTrack\Model\Movement;

class MainController extends ViewController
{
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
     * Selects an Order.
     */
    public function doSelectOrder(): bool
    {
        $this->checkIdentification();

        $orders = Order::orderBy('id', 'desc')->take(20)->get();

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
    public function doSelectFamily(int $centerId): bool
    {
        $this->checkIdentification();
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
    public function doSelectProcess(int $familyId): bool
    {
        $this->checkIdentification();
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
    public function doSelectSequence(int $processId): bool
    {
        $this->checkIdentification();
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
     * Records the movement.
     */
    public function doRecord(): bool
    {
        $this->checkIdentification();

        $sequenceId = (int)($_POST['sequence_id'] ?? 0);
        $units = (int)($_POST['units'] ?? 1);
        $duration = (int)($_POST['duration'] ?? 0);

        $data = $_SESSION['labtrack'];

        $movement = new Movement();
        $movement->operator_id = $data['operator_id'];
        $movement->order_id = $data['order_id'];
        $movement->cost_center_id = $data['cost_center_id'];
        $movement->family_id = $data['family_id'];
        $movement->process_id = $data['process_id'];
        $movement->sequence_id = $sequenceId;
        $movement->units = $units;
        $movement->duration_minutes = $duration;
        $movement->save();

        // Clear workflow but keep operator
        unset($_SESSION['labtrack']['order_id']);
        unset($_SESSION['labtrack']['cost_center_id']);
        unset($_SESSION['labtrack']['family_id']);
        unset($_SESSION['labtrack']['process_id']);

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
