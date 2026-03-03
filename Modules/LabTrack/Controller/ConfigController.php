<?php

declare(strict_types=1);

namespace Modules\LabTrack\Controller;

use CoreModules\Admin\Controller\PublicController;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Trans;
use Alxarafe\Base\Database;
use Modules\LabTrack\Model\Operator;
use CoreModules\Admin\Model\User;
use Modules\LabTrack\Model\CostCenter;
use Modules\LabTrack\Model\Family;
use Modules\LabTrack\Model\Process;
use Modules\LabTrack\Model\Sequence;
use Alxarafe\Attribute\Menu;

#[Menu(
    menu: 'admin_sidebar',
    label: 'configuration',
    icon: 'fa-cog',
    order: 40,
    permission: 'LabTrack.Config.index'
)]
class ConfigController extends PublicController
{
    /**
     * @inheritDoc
     */
    public function beforeAction(): bool
    {
        if (!parent::beforeAction()) {
            return false;
        }

        if (!Auth::$user || !Auth::$user->is_admin) {
            Functions::httpRedirect('/');
            return false;
        }

        $this->protectChanges = true;

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
        return 'Config';
    }

    /**
     * Configuration main menu.
     */
    public function doIndex(): bool
    {
        $this->addVariables([
            'title' => '<i class="fas fa-cogs me-3"></i>' . Trans::_('configuration'),
        ]);
        $this->setDefaultTemplate('labtrack/config/index');
        return true;
    }

    /**
     * Operator management.
     */
    public function doUsers(): bool
    {
        $operators = Operator::orderBy('name')->get();

        // Get admin and supervisor status directly from Alxarafe users
        $users = Database::connection()->table('users')
            ->select('id', 'is_admin', 'role_id')
            ->get()
            ->keyBy('id');

        foreach ($operators as $operator) {
            $user = $users->get($operator->user_id);
            if ($user) {
                $operator->isAdmin = (bool)$user->is_admin;
                $operator->isSupervisor = ($user->role_id == 2);
            } else {
                $operator->isAdmin = false;
                $operator->isSupervisor = false;
            }
        }

        $this->addVariables([
            'title' => '<i class="fas fa-users me-3"></i>' . Trans::_('operator_management'),
            'operators' => $operators,
        ]);
        $this->setDefaultTemplate('labtrack/config/users');
        return true;
    }

    /**
     * Saves operator management data.
     */
    public function doSaveUsers(): bool
    {
        $ids = $_POST['id'] ?? [];
        $pins = $_POST['pin'] ?? [];
        $names = $_POST['name'] ?? [];
        $admins = $_POST['admin'] ?? [];
        $supervisors = $_POST['supervisor'] ?? [];
        $offs = $_POST['off'] ?? [];

        Database::connection()->beginTransaction();

        try {
            foreach ($ids as $key => $id) {
                $id = (int)$id;
                $name = $names[$key];
                $pin = $pins[$key];
                $isAdmin = isset($admins[$key]);
                $isSupervisor = isset($supervisors[$key]);
                $isActive = !isset($offs[$key]);

                $operator = Operator::findOrNew($id);
                $operator->name = $name;
                $operator->pin = $pin;
                $operator->active = $isActive;
                $operator->save();

                // If admin/supervisor, ensure there's a corresponding Alxarafe user
                if ($isAdmin || $isSupervisor) {
                    $user = User::find($operator->user_id ?: $operator->id);
                    if (!$user) {
                        $user = new User();
                        $user->id = $operator->id;
                        $user->name = $name;
                        $user->password = md5('password');
                        $user->email = $operator->id . '@labtrack.local';
                        $user->save();
                        $operator->user_id = $user->id;
                        $operator->save();
                    }

                    $user->is_admin = $isAdmin;
                    $user->role_id = $isSupervisor ? 2 : null;
                    $user->save();
                }
            }
            Database::connection()->commit();
        } catch (\Exception $e) {
            Database::connection()->rollBack();
            throw $e;
        }

        Functions::httpRedirect($this::url('users'));
        return true;
    }

    /**
     * Cost center management.
     */
    public function doCenters(): bool
    {
        $centers = CostCenter::orderBy('sort_order')->get();

        $this->addVariables([
            'title' => '<i class="fas fa-building me-3"></i>' . Trans::_('cost_center_management'),
            'centers' => $centers,
        ]);
        $this->setDefaultTemplate('labtrack/config/centers');
        return true;
    }

    /**
     * Saves cost center management data.
     */
    public function doSaveCenters(): bool
    {
        $ids = $_POST['id'] ?? [];
        $orders = $_POST['sort_order'] ?? [];
        $names = $_POST['name'] ?? [];
        $buttons = $_POST['button_text'] ?? [];
        $offs = $_POST['off'] ?? [];

        foreach ($ids as $key => $id) {
            $center = CostCenter::findOrNew($id);
            $center->sort_order = (int)$orders[$key];
            $center->name = $names[$key];
            $center->button_text = $buttons[$key] ?: $names[$key];
            $center->active = !isset($offs[$key]);
            $center->save();
        }

        Functions::httpRedirect($this::url('centers'));
        return true;
    }

    /**
     * Family management.
     */
    public function doFamilies(): bool
    {
        $families = Family::orderBy('sort_order')->get();
        $centers = CostCenter::where('active', 1)->orderBy('sort_order')->get();

        $this->addVariables([
            'title' => '<i class="fas fa-tags me-3"></i>' . Trans::_('family_management'),
            'families' => $families,
            'centers' => $centers,
        ]);
        $this->setDefaultTemplate('labtrack/config/families');
        return true;
    }

    /**
     * Saves family management data.
     */
    public function doSaveFamilies(): bool
    {
        $ids = $_POST['id'] ?? [];
        $centers = $_POST['cost_center_id'] ?? [];
        $orders = $_POST['sort_order'] ?? [];
        $names = $_POST['name'] ?? [];
        $buttons = $_POST['button_text'] ?? [];
        $offs = $_POST['off'] ?? [];

        foreach ($ids as $key => $id) {
            $family = Family::findOrNew($id);
            $family->cost_center_id = (int)$centers[$key];
            $family->sort_order = (int)$orders[$key];
            $family->name = $names[$key];
            $family->button_text = $buttons[$key] ?: $names[$key];
            $family->active = !isset($offs[$key]);
            $family->save();
        }

        Functions::httpRedirect($this::url('families'));
        return true;
    }

    /**
     * Process management.
     */
    public function doProcesses(?int $processId = null): bool
    {
        if ($processId) {
            $process = Process::find($processId);
            $families = Family::where('active', 1)->orderBy('sort_order')->get();
            $marked = Database::connection()->table('family_process')
                ->where('process_id', $processId)
                ->pluck('family_id')
                ->toArray();

            $this->addVariables([
                'title' => Trans::_('select_families') . ': ' . $process->name,
                'process' => $process,
                'families' => $families,
                'marked' => $marked,
            ]);
            $this->setDefaultTemplate('labtrack/config/select_families');
            return true;
        }

        $processes = Process::orderBy('sort_order')->get();

        $this->addVariables([
            'title' => '<i class="fas fa-cogs me-3"></i>' . Trans::_('process_management'),
            'processes' => $processes,
        ]);
        $this->setDefaultTemplate('labtrack/config/processes');
        return true;
    }

    /**
     * Saves process management data.
     */
    public function doSaveProcesses(): bool
    {
        $ids = $_POST['id'] ?? [];
        $orders = $_POST['sort_order'] ?? [];
        $names = $_POST['name'] ?? [];
        $buttons = $_POST['button_text'] ?? [];
        $offs = $_POST['off'] ?? [];

        foreach ($ids as $key => $id) {
            $process = Process::findOrNew($id);
            $process->sort_order = (int)$orders[$key];
            $process->name = $names[$key];
            $process->button_text = $buttons[$key] ?: $names[$key];
            $process->active = !isset($offs[$key]);
            $process->save();
        }

        Functions::httpRedirect($this::url('processes'));
        return true;
    }

    /**
     * Saves family associations for a process.
     */
    public function doSaveProcessFamilies(int $processId): bool
    {
        $families = $_POST['families'] ?? [];

        Database::connection()->table('family_process')->where('process_id', $processId)->delete();

        foreach ($families as $familyId) {
            Database::connection()->table('family_process')->insert([
                'process_id' => $processId,
                'family_id' => (int)$familyId
            ]);
        }

        Functions::httpRedirect($this::url('processes'));
        return true;
    }

    /**
     * Sequence management.
     */
    public function doSequences(?int $sequenceId = null): bool
    {
        if ($sequenceId) {
            $sequence = Sequence::find($sequenceId);
            $processes = Process::where('active', 1)->orderBy('sort_order')->get();
            $marked = Database::connection()->table('process_sequence')
                ->where('sequence_id', $sequenceId)
                ->pluck('process_id')
                ->toArray();

            $this->addVariables([
                'title' => Trans::_('select_processes') . ': ' . $sequence->name,
                'sequence' => $sequence,
                'processes' => $processes,
                'marked' => $marked,
            ]);
            $this->setDefaultTemplate('labtrack/config/select_processes');
            return true;
        }

        $sequences = Sequence::orderBy('sort_order')->get();

        $this->addVariables([
            'title' => '<i class="fas fa-list-ol me-3"></i>' . Trans::_('sequence_management'),
            'sequences' => $sequences,
        ]);
        $this->setDefaultTemplate('labtrack/config/sequences');
        return true;
    }

    /**
     * Saves sequence management data.
     */
    public function doSaveSequences(): bool
    {
        $ids = $_POST['id'] ?? [];
        $orders = $_POST['sort_order'] ?? [];
        $names = $_POST['name'] ?? [];
        $buttons = $_POST['button_text'] ?? [];
        $durations = $_POST['duration_minutes'] ?? [];
        $editables = $_POST['duration_editable'] ?? [];
        $offs = $_POST['off'] ?? [];

        foreach ($ids as $key => $id) {
            $sequence = Sequence::findOrNew($id);
            $sequence->sort_order = (int)$orders[$key];
            $sequence->name = $names[$key];
            $sequence->button_text = $buttons[$key] ?: $names[$key];
            $sequence->duration_minutes = (int)$durations[$key];
            $sequence->duration_editable = isset($editables[$key]);
            $sequence->active = !isset($offs[$key]);
            $sequence->save();
        }

        Functions::httpRedirect($this::url('sequences'));
        return true;
    }

    /**
     * Saves process associations for a sequence.
     */
    public function doSaveSequenceProcesses(int $sequenceId): bool
    {
        $processes = $_POST['processes'] ?? [];

        Database::connection()->table('process_sequence')->where('sequence_id', $sequenceId)->delete();

        foreach ($processes as $processId) {
            Database::connection()->table('process_sequence')->insert([
                'sequence_id' => $sequenceId,
                'process_id' => (int)$processId
            ]);
        }

        Functions::httpRedirect($this::url('sequences'));
        return true;
    }
}
