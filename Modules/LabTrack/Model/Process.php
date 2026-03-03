<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Process extends Model
{
    protected $table = 'processes';

    protected $fillable = [
        'sort_order',
        'name',
        'button_text',
        'active',
    ];

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class, 'family_process');
    }

    public function sequences(): BelongsToMany
    {
        return $this->belongsToMany(Sequence::class, 'process_sequence');
    }
}
