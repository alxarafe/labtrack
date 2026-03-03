<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movement extends Model
{
    protected $table = 'movements';

    protected $fillable = [
        'operator_id',
        'order_id',
        'cost_center_id',
        'family_id',
        'process_id',
        'sequence_id',
        'units',
        'duration_minutes',
        'notes',
        'movement_at',
        'supervised_by',
    ];

    public $timestamps = false; // We use movement_at

    public function operator(): BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }

    public function sequence(): BelongsTo
    {
        return $this->belongsTo(Sequence::class);
    }
}
