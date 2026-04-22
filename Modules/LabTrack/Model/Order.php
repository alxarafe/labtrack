<?php

declare(strict_types=1);

namespace Modules\LabTrack\Model;

use Alxarafe\Infrastructure\Persistence\Model\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'name',
    ];
}
