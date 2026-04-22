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
use Modules\LabTrack\Domain\Model\Movement;
use Modules\LabTrack\Domain\Port\Driven\MovementRepositoryInterface;

class PdoMovementRepository implements MovementRepositoryInterface
{
    private const TABLE = 'alx_movements';

    public function __construct(private PersistencePort $db)
    {
    }

    public function findById(int $id): ?Movement
    {
        $row = $this->db->findById(self::TABLE, $id);
        return $row ? Movement::fromArray($row) : null;
    }

    public function save(Movement $movement): void
    {
        $data = $movement->toArray();
        if ($movement->getId() === null) {
            unset($data['id']);
            $id = $this->db->insert(self::TABLE, $data);
            $movement->setId((int) $id);
        } else {
            $this->db->update(self::TABLE, $movement->getId(), $data);
        }
    }

    public function delete(int $id): void
    {
        $this->db->delete(self::TABLE, $id);
    }

    /**
     * @return Movement[]
     */
    public function findByOrderId(int $orderId, bool $descending = false): array
    {
        $rows = $this->db->findBy(self::TABLE, ['order_id' => $orderId]);

        // Sort by movement_at
        usort($rows, function ($a, $b) use ($descending) {
            $cmp = ($a['movement_at'] ?? '') <=> ($b['movement_at'] ?? '');
            return $descending ? -$cmp : $cmp;
        });

        return array_map(fn($row) => Movement::fromArray($row), $rows);
    }

    /**
     * @return Movement[]
     */
    public function findPendingSupervision(): array
    {
        $rows = $this->db->findBy(self::TABLE, ['supervised_by' => null]);
        return array_map(fn($row) => Movement::fromArray($row), $rows);
    }

    /**
     * @return Movement[]
     */
    public function findByFilters(array $filters = []): array
    {
        $rows = $this->db->findBy(self::TABLE, $filters);
        return array_map(fn($row) => Movement::fromArray($row), $rows);
    }

    /**
     * @inheritDoc
     */
    public function findDetailedByOrderId(int $orderId, bool $descending = false): array
    {
        $order = $descending ? 'DESC' : 'ASC';

        $sql = "
            SELECT
                m.*,
                o.name as order_name,
                op.name as operator_name,
                cc.name as cost_center_name,
                f.name as family_name,
                s.name as sequence_name,
                p.name as process_name
            FROM alx_movements m
            LEFT JOIN alx_orders o ON m.order_id = o.id
            LEFT JOIN alx_operators op ON m.operator_id = op.id
            LEFT JOIN alx_cost_centers cc ON m.cost_center_id = cc.id
            LEFT JOIN alx_families f ON m.family_id = f.id
            LEFT JOIN alx_sequences s ON m.sequence_id = s.id
            LEFT JOIN alx_processes p ON m.process_id = p.id
            WHERE m.order_id = :order_id
            ORDER BY m.movement_at {$order}
        ";
        
        return $this->db->rawQuery($sql, ['order_id' => $orderId]);
    }

    /**
     * @inheritDoc
     */
    public function findUserReport(int|array $userId, string $from, string $to): array
    {
        if (is_array($userId)) {
            $placeholders = implode(',', array_fill(0, count($userId), '?'));
            $whereClause = "m.operator_id IN ({$placeholders})";
            $params = array_merge($userId, [$from, $to . ' 23:59:59']);
        } else {
            $whereClause = "m.operator_id = ?";
            $params = [$userId, $from, $to . ' 23:59:59'];
        }

        $sql = "
            SELECT
                m.*,
                o.name as order_name,
                op.name as operator_name,
                cc.name as cost_center_name,
                f.name as family_name,
                s.name as sequence_name,
                p.name as process_name
            FROM alx_movements m
            LEFT JOIN alx_orders o ON m.order_id = o.id
            LEFT JOIN alx_operators op ON m.operator_id = op.id
            LEFT JOIN alx_cost_centers cc ON m.cost_center_id = cc.id
            LEFT JOIN alx_families f ON m.family_id = f.id
            LEFT JOIN alx_sequences s ON m.sequence_id = s.id
            LEFT JOIN alx_processes p ON m.process_id = p.id
            WHERE {$whereClause}
              AND m.movement_at BETWEEN ? AND ?
            ORDER BY op.name, cc.name, s.name, f.name, p.name
        ";
        
        return $this->db->rawQuery($sql, $params);
    }
}
