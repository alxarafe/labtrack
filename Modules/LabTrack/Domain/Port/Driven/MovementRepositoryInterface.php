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

use Modules\LabTrack\Domain\Model\Movement;

interface MovementRepositoryInterface
{
    public function findById(int $id): ?Movement;

    public function save(Movement $movement): void;

    public function delete(int $id): void;

    /**
     * @return Movement[]
     */
    public function findByOrderId(int $orderId, bool $descending = false): array;

    /**
     * @return Movement[]
     */
    public function findPendingSupervision(): array;

    /**
     * @return Movement[]
     */
    public function findByFilters(array $filters = []): array;

    /**
     * Get detailed movements with joined names for reporting.
     * @return array<int, array<string, mixed>>
     */
    public function findDetailedByOrderId(int $orderId, bool $descending = false): array;

    /**
     * Get user production report with joined names.
     * @param int|int[] $userId
     * @return array<int, array<string, mixed>>
     */
    public function findUserReport(int|array $userId, string $from, string $to): array;
}
