<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sequence extends Model
{
    protected $table = 'sequences';

    protected $fillable = [
        'sort_order',
        'name',
        'button_text',
        'duration_minutes',
        'duration_editable',
        'active',
    ];

    public function processes(): BelongsToMany
    {
        return $this->belongsToMany(Process::class, 'process_sequence');
    }
}
