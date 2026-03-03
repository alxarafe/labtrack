<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Family extends Model
{
    protected $table = 'families';

    protected $fillable = [
        'cost_center_id',
        'sort_order',
        'name',
        'button_text',
        'active',
    ];

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class, 'family_process');
    }
}
