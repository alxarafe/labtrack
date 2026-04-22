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

namespace Modules\LabTrack\Application\Bus\Command;

use Alxarafe\Application\Bus\Command;

readonly class RecordMovementCommand implements Command
{
    public function __construct(
        public int $operatorId,
        public int $orderId,
        public int $costCenterId,
        public int $familyId,
        public int $processId,
        public int $sequenceId,
        public int $units = 1,
        public int $durationMinutes = 0,
        public int $repeated = 0,
        public ?string $notes = null
    ) {
    }
}
