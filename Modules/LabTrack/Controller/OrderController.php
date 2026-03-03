<?php

declare(strict_types=1);

namespace Modules\LabTrack\Controller;

use CoreModules\Admin\Controller\PublicController;
use Alxarafe\Lib\Trans;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Auth;
use Modules\LabTrack\Model\Order;
use Modules\LabTrack\Model\Movement;
use Modules\LabTrack\Model\CostCenter;
use Modules\LabTrack\Model\Family;
use Modules\LabTrack\Model\Process;
use Modules\LabTrack\Model\Sequence;

use Alxarafe\Attribute\Menu;

#[Menu(
    menu: 'admin_sidebar',
    label: 'order_management',
    icon: 'fa-barcode',
    order: 20,
    permission: 'LabTrack.Order.index'
)]
/**
 * Controller for managing lab work orders.
 */
class OrderController extends PublicController
{
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
        return 'Order';
    }

    /**
     * Main action for order management.
     *
     * @return bool
     */
    public function doIndex(): bool
    {
        $orderId = $_POST['order'] ?? $_GET['order'] ?? null;

        if ($orderId) {
            return $this->handleOrderView((int)$orderId);
        }

        $this->addVariables([
            'title' => Trans::_('order_management'),
            'description' => Trans::_('order_management_description'),
        ]);

        $this->setDefaultTemplate('labtrack/order/index');

        return true;
    }

    /**
     * Saves a new order or updates an existing one.
     *
     * @return bool
     */
    public function doSave(): bool
    {
        $id = $_POST['id'] ?? null;
        $name = $_POST['name'] ?? $_POST['nombre'] ?? '';

        $order = $id ? Order::findOrNew($id) : new Order();
        $order->name = $name;
        $order->save();

        if (isset($_SESSION['labtrack']['operator_id'])) {
            // If we are in the middle of a station workflow
            $_SESSION['labtrack']['order_id'] = $order->id;
            Functions::httpRedirect($this::url('Main.selectCenter'));
            return true;
        }

        Functions::httpRedirect($this::url('index', ['order' => $order->id]));

        return true;
    }

    /**
     * Adds a new production record (movement).
     *
     * @return bool
     */
    public function doAddRecord(): bool
    {
        $data = $_POST;

        $movement = new Movement();
        $movement->order_id = (int)($data['order_id'] ?? 0);
        $movement->cost_center_id = (int)($data['center_id'] ?? 0);
        $movement->family_id = (int)($data['family_id'] ?? 0);
        $movement->process_id = (int)($data['process_id'] ?? 0);
        $movement->sequence_id = (int)($data['sequence_id'] ?? 0);
        $movement->units = (int)($data['units'] ?? 1);
        $movement->duration_minutes = (int)($data['duration'] ?? 0);
        $movement->notes = $data['notes'] ?? '';
        $movement->operator_id = Auth::$user->id ?? 0; // In admin view, we use the logged user
        $movement->supervised_by = null;

        $movement->save();

        Functions::httpRedirect($this::url('index', [
            'order' => $movement->order_id,
            'center' => $movement->cost_center_id,
            'family' => $movement->family_id,
            'process' => $movement->process_id,
        ]));

        return true;
    }

    /**
     * Handles the view for a specific order.
     *
     * @param int $orderId
     * @return bool
     */
    protected function handleOrderView(int $orderId): bool
    {
        $order = Order::find($orderId);

        if (!$order) {
            $this->addVariables([
                'title' => Trans::_('new_order'),
                'orderId' => $orderId,
            ]);
            $this->setDefaultTemplate('labtrack/order/create');
            return true;
        }

        // Drill-down selection logic
        $centerId = (int)($_GET['center'] ?? 0);
        $familyId = (int)($_GET['family'] ?? 0);
        $processId = (int)($_GET['process'] ?? 0);

        $centers = CostCenter::where('active', 1)->orderBy('sort_order')->get();
        $families = $centerId ? Family::where('cost_center_id', $centerId)->where('active', 1)->orderBy('sort_order')->get() : [];

        $processes = [];
        if ($familyId) {
            $family = Family::find($familyId);
            if ($family) {
                $processes = $family->processes()->where('active', 1)->orderBy('sort_order')->get();
            }
        }

        $sequences = [];
        if ($processId) {
            $process = Process::find($processId);
            if ($process) {
                $sequences = $process->sequences()->where('active', 1)->orderBy('sort_order')->get();
            }
        }

        // Logic for existing order (Editar Orden)
        $movements = Movement::where('order_id', $orderId)
            ->with(['operator']) // Sequence? Check relationships in Model
            ->orderBy('movement_at', 'desc')
            ->get();

        $this->addVariables([
            'title' => Trans::_('order_dashboard'),
            'order' => $order,
            'movements' => $movements,
            'centers' => $centers,
            'families' => $families,
            'processes' => $processes,
            'sequences' => $sequences,
            'centerId' => $centerId,
            'familyId' => $familyId,
            'processId' => $processId,
        ]);
        $this->setDefaultTemplate('labtrack/order/edit');

        return true;
    }
}
