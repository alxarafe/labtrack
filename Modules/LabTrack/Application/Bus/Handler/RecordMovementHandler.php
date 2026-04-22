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
use Modules\LabTrack\Application\Bus\Command\RecordMovementCommand;
use Modules\LabTrack\Domain\Model\Movement;
use Modules\LabTrack\Domain\Port\Driven\MovementRepositoryInterface;

class RecordMovementHandler implements CommandHandler
{
    public function __construct(private MovementRepositoryInterface $movementRepository)
    {
    }

    /**
     * @param RecordMovementCommand $command
     */
    public function handle(Command $command): mixed
    {
        $movement = new Movement(
            $command->operatorId,
            $command->orderId,
            $command->costCenterId,
            $command->familyId,
            $command->processId,
            $command->sequenceId,
            $command->units,
            $command->durationMinutes,
            $command->repeated,
            $command->notes
        );

        $this->movementRepository->save($movement);

        return $movement->getId();
    }
}
