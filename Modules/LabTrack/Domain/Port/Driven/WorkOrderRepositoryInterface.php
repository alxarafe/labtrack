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

namespace Modules\LabTrack\Domain\Port\Driven;

use Modules\LabTrack\Domain\Model\WorkOrder;

interface WorkOrderRepositoryInterface
{
    public function findById(int $id): ?WorkOrder;

    public function save(WorkOrder $order): void;

    public function delete(int $id): void;

    /**
     * @return WorkOrder[]
     */
    public function findAll(): array;

    /**
     * @return WorkOrder[]
     */
    public function findRecent(int $limit = 20): array;
}
