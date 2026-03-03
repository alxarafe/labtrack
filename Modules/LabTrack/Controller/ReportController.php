<?php

declare(strict_types=1);

namespace Modules\LabTrack\Controller;

use CoreModules\Admin\Controller\PublicController;
use Alxarafe\Lib\Trans;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use Modules\LabTrack\Model\Operator;
use Modules\LabTrack\Model\Movement;
use CoreModules\Admin\Model\User;
use Carbon\Carbon;

use Alxarafe\Attribute\Menu;

#[Menu(
    menu: 'admin_sidebar',
    label: 'reports',
    icon: 'fa-chart-bar',
    order: 30,
    permission: 'LabTrack.Report.index'
)]
/**
 * Controller for generating and managing production reports.
 */
class ReportController extends PublicController
{
    /**
     * @var bool
     */
    protected bool $isSupervisor = false;

    /**
     * @inheritDoc
     */
    public function beforeAction(): bool
    {
        if (!parent::beforeAction()) {
            return false;
        }

        if (!Auth::$user) {
            return true;
        }

        // A supervisor is an admin OR someone with role_id 2
        // A supervisor is an admin OR someone with role_id 2
        $this->isSupervisor = (Auth::$user->is_admin ?? false) || (Auth::$user->role_id == 2);

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function getModuleName(): string
    {
        return 'LabTrack';
    }

    /**
     * @inheritDoc
     */
    public static function getControllerName(): string
    {
        return 'Report';
    }

    /**
     * Main action for reports.
     *
     * @return bool
     */
    public function doIndex(): bool
    {
        $this->addVariable('title', '<i class="fas fa-chart-bar me-3"></i>' . Trans::_('reports'));
        if ($this->isSupervisor) {
            $this->setDefaultTemplate('labtrack/report/index');
        } else {
            Functions::httpRedirect($this::url('Operator'));
        }

        return true;
    }

    /**
     * Shows a report for a specific operator.
     *
     * @return bool
     */
    public function doOperator(): bool
    {
        $operatorId = (int)($_POST['operator_id'] ?? $_GET['operator_id'] ?? 0);

        // Security: non-supervisors should probably not see this unless matched to their user
        if (!$this->isSupervisor) {
            $currentOperator = Operator::where('user_id', Auth::$user->id)->first();
            $operatorId = $currentOperator ? $currentOperator->id : 0;
        }

        $from = $_POST['date_from'] ?? $_GET['date_from'] ?? Carbon::now()->subMonth()->format('Y-m-d');
        $to = $_POST['date_to'] ?? $_GET['date_to'] ?? Carbon::now()->format('Y-m-d');

        $operators = [];
        if ($this->isSupervisor) {
            $operators = Operator::orderBy('name')->get();
        }

        $report = [];
        if ($operatorId && (isset($_POST['accept']) || isset($_GET['operator_id']))) {
            $report = Movement::where('operator_id', $operatorId)
                ->whereBetween('movement_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->with(['operator', 'order', 'costCenter', 'family', 'process', 'sequence'])
                ->orderBy('movement_at', 'asc')
                ->get();
        }

        $this->addVariables([
            'title' => '<i class="fas fa-user-chart me-3"></i>' . Trans::_('user_report'),
            'operators' => $operators,
            'report' => $report,
            'operatorId' => $operatorId,
            'dateFrom' => $from,
            'dateTo' => $to,
            'isSupervisor' => $this->isSupervisor,
        ]);

        $this->setDefaultTemplate('labtrack/report/user');

        return true;
    }

    /**
     * Shows detailed movements for a specific order.
     *
     * @return bool
     */
    public function doOrder(): bool
    {
        if (!$this->isSupervisor) {
            Functions::httpRedirect($this::url('Operator'));
        }

        $orderId = $_POST['order_id'] ?? $_GET['order_id'] ?? '';
        $report = [];

        if ($orderId && (isset($_POST['accept']) || isset($_GET['order_id']))) {
            $report = Movement::where('order_id', $orderId)
                ->with(['operator', 'costCenter', 'family', 'process', 'sequence'])
                ->orderBy('movement_at', 'asc')
                ->get();
        }

        $this->addVariables([
            'title' => '<i class="fas fa-file-invoice me-3"></i>' . Trans::_('order_report'),
            'report' => $report,
            'orderId' => $orderId,
            'isSupervisor' => $this->isSupervisor,
        ]);

        $this->setDefaultTemplate('labtrack/report/order');

        return true;
    }

    /**
     * Validates/supervises a movement.
     *
     * @return bool
     */
    public function doValidate(): bool
    {
        if (!$this->isSupervisor) {
            return false;
        }

        $id = (int)($_GET['id'] ?? 0);
        $movement = Movement::find($id);

        if ($movement) {
            $movement->supervised_by = Auth::$user->id; // Using Alxarafe User ID as supervisor
            $movement->save();
        }

        Functions::httpRedirect($_SERVER['HTTP_REFERER'] ?? $this::url('index'));

        return true;
    }

    /**
     * Exports a report to CSV.
     *
     * @return bool
     */
    public function doExport(): bool
    {
        $orderId = $_GET['order_id'] ?? null;
        $operatorId = $_GET['operator_id'] ?? null;
        $from = $_GET['date_from'] ?? null;
        $to = $_GET['date_to'] ?? null;

        $query = Movement::with(['operator', 'order', 'costCenter', 'family', 'process', 'sequence']);

        if ($orderId) {
            $query->where('order_id', $orderId);
            $filename = "report_order_{$orderId}_" . date('YmdHis') . ".csv";
        } elseif ($operatorId) {
            // Security check
            if (!$this->isSupervisor) {
                $currentOperator = Operator::where('user_id', Auth::$user->id)->first();
                if (!$currentOperator || $operatorId != $currentOperator->id) {
                    return false;
                }
            }
            $query->where('operator_id', $operatorId);
            if ($from && $to) {
                $query->whereBetween('movement_at', [$from . ' 00:00:00', $to . ' 23:59:59']);
            }
            $filename = "report_operator_{$operatorId}_" . date('YmdHis') . ".csv";
        } else {
            return false;
        }

        $data = $query->orderBy('movement_at', 'asc')->get();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, [
            'ID',
            'Order',
            'Operator',
            'Time',
            'Cost Center',
            'Family',
            'Process',
            'Sequence',
            'Units',
            'Duration',
            'Notes',
            'Supervisor'
        ], ';');

        foreach ($data as $row) {
            fputcsv($output, [
                $row->id,
                $row->order->name ?? $row->order_id,
                $row->operator->name ?? $row->operator_id,
                $row->movement_at,
                $row->costCenter->name ?? '',
                $row->family->name ?? '',
                $row->process->name ?? '',
                $row->sequence->name ?? '',
                $row->units,
                $row->duration_minutes,
                $row->notes,
                $row->supervised_by ?? ''
            ], ';');
        }

        fclose($output);
        exit;
    }
}
