<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Base\Model\Model;
use CoreModules\Admin\Model\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operator extends Model
{
    protected $table = 'operators';

    protected $fillable = [
        'name',
        'pin',
        'user_id',
        'active',
    ];

    /**
     * Get the associated Alxarafe user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
