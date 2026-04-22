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

namespace Modules\LabTrack\Infrastructure\Adapter\Persistence;

use Alxarafe\Domain\Port\Driven\PersistencePort;
use Modules\LabTrack\Domain\Model\WorkOrder;
use Modules\LabTrack\Domain\Port\Driven\WorkOrderRepositoryInterface;

class PdoWorkOrderRepository implements WorkOrderRepositoryInterface
{
    private const TABLE = 'alx_orders';

    public function __construct(private PersistencePort $db)
    {
    }

    public function findById(int $id): ?WorkOrder
    {
        $row = $this->db->findById(self::TABLE, $id);
        return $row ? WorkOrder::fromArray($row) : null;
    }

    public function save(WorkOrder $order): void
    {
        $data = $order->toArray();
        if ($order->getId() === null) {
            unset($data['id']);
            $id = $this->db->insert(self::TABLE, $data);
            $order->setId((int) $id);
        } else {
            $this->db->update(self::TABLE, $order->getId(), $data);
        }
    }

    public function delete(int $id): void
    {
        $this->db->delete(self::TABLE, $id);
    }

    /**
     * @return WorkOrder[]
     */
    public function findAll(): array
    {
        $rows = $this->db->findBy(self::TABLE, []);
        return array_map(fn($row) => WorkOrder::fromArray($row), $rows);
    }

    /**
     * @return WorkOrder[]
     */
    public function findRecent(int $limit = 20): array
    {
        $rows = $this->db->findBy(self::TABLE, [], ['id' => 'DESC'], $limit);
        return array_map(fn($row) => WorkOrder::fromArray($row), $rows);
    }
}
