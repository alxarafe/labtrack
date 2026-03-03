<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Base\Model\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'name',
    ];
}
