<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

namespace Modules\LabTrack\Application\Bus\Handler;

use Alxarafe\Application\Bus\CommandHandler;
use Alxarafe\Application\Bus\Command;
use Modules\LabTrack\Application\Bus\Command\CreateOrderCommand;
use Modules\LabTrack\Domain\Model\WorkOrder;
use Modules\LabTrack\Domain\Port\Driven\WorkOrderRepositoryInterface;

class CreateOrderHandler implements CommandHandler
{
    public function __construct(private WorkOrderRepositoryInterface $orderRepository)
    {
    }

    /**
     * @param CreateOrderCommand $command
     */
    public function handle(Command $command): mixed
    {
        $order = new WorkOrder($command->name);

        $this->orderRepository->save($order);

        return $order->getId();
    }
}
