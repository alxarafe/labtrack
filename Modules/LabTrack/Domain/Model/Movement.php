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

namespace Modules\LabTrack\Domain\Model;

use DateTimeImmutable;

class Movement
{
    private ?int $id = null;
    private int $operatorId;
    private int $orderId;
    private int $costCenterId;
    private int $familyId;
    private int $processId;
    private int $sequenceId;
    private int $units;
    private int $durationMinutes;
    private int $repeated;
    private ?int $supervisedBy;
    private ?string $notes;
    private ?DateTimeImmutable $movementAt;

    public function __construct(
        int $operatorId,
        int $orderId,
        int $costCenterId,
        int $familyId,
        int $processId,
        int $sequenceId,
        int $units = 1,
        int $durationMinutes = 0,
        int $repeated = 0,
        ?string $notes = null
    ) {
        $this->operatorId = $operatorId;
        $this->orderId = $orderId;
        $this->costCenterId = $costCenterId;
        $this->familyId = $familyId;
        $this->processId = $processId;
        $this->sequenceId = $sequenceId;
        $this->units = $units;
        $this->durationMinutes = $durationMinutes;
        $this->repeated = $repeated;
        $this->notes = $notes;
        $this->supervisedBy = null;
        $this->movementAt = new DateTimeImmutable();
    }

    public static function fromArray(array $data): self
    {
        $movement = new self(
            (int) ($data['operator_id'] ?? 0),
            (int) ($data['order_id'] ?? 0),
            (int) ($data['cost_center_id'] ?? 0),
            (int) ($data['family_id'] ?? 0),
            (int) ($data['process_id'] ?? 0),
            (int) ($data['sequence_id'] ?? 0),
            (int) ($data['units'] ?? 1),
            (int) ($data['duration_minutes'] ?? 0),
            (int) ($data['repeated'] ?? 0),
            $data['notes'] ?? null
        );

        $movement->id = isset($data['id']) ? (int) $data['id'] : null;
        $movement->supervisedBy = isset($data['supervised_by']) ? (int) $data['supervised_by'] : null;

        if (!empty($data['movement_at'])) {
            $movement->movementAt = new DateTimeImmutable($data['movement_at']);
        }

        return $movement;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'operator_id' => $this->operatorId,
            'order_id' => $this->orderId,
            'cost_center_id' => $this->costCenterId,
            'family_id' => $this->familyId,
            'process_id' => $this->processId,
            'sequence_id' => $this->sequenceId,
            'units' => $this->units,
            'duration_minutes' => $this->durationMinutes,
            'repeated' => $this->repeated,
            'supervised_by' => $this->supervisedBy,
            'notes' => $this->notes,
            'movement_at' => $this->movementAt?->format('Y-m-d H:i:s'),
        ];
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getOperatorId(): int
    {
        return $this->operatorId;
    }
    public function getOrderId(): int
    {
        return $this->orderId;
    }
    public function getCostCenterId(): int
    {
        return $this->costCenterId;
    }
    public function getFamilyId(): int
    {
        return $this->familyId;
    }
    public function getProcessId(): int
    {
        return $this->processId;
    }
    public function getSequenceId(): int
    {
        return $this->sequenceId;
    }
    public function getUnits(): int
    {
        return $this->units;
    }
    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }
    public function getRepeated(): int
    {
        return $this->repeated;
    }
    public function getSupervisedBy(): ?int
    {
        return $this->supervisedBy;
    }
    public function getNotes(): ?string
    {
        return $this->notes;
    }
    public function getMovementAt(): ?DateTimeImmutable
    {
        return $this->movementAt;
    }
    public function isSupervised(): bool
    {
        return $this->supervisedBy !== null && $this->supervisedBy > 0;
    }

    // Setters / Actions
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function supervise(int $supervisorId): void
    {
        $this->supervisedBy = $supervisorId;
    }

    public function updateDetails(int $units, int $durationMinutes, int $repeated, ?string $notes): void
    {
        $this->units = $units;
        $this->durationMinutes = $durationMinutes;
        $this->repeated = $repeated;
        $this->notes = $notes;
    }

    public function __get(string $name): mixed
    {
        $camelCase = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $name))));
        $method = 'get' . ucfirst($camelCase);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        $methodIs = 'is' . ucfirst($camelCase);
        if (method_exists($this, $methodIs)) {
            return $this->$methodIs();
        }
        if (property_exists($this, $camelCase)) {
            return $this->$camelCase;
        }
        return null;
    }
}
