<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Infrastructure\Persistence\Model\Model;

class CostCenter extends Model
{
    protected $table = 'cost_centers';

    protected $fillable = [
        'sort_order',
        'name',
        'button_text',
        'active',
    ];
}
