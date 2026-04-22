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

class WorkOrder
{
    private ?int $id = null;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromArray(array $data): self
    {
        $order = new self($data['name'] ?? '');
        $order->id = isset($data['id']) ? (int) $data['id'] : null;
        return $order;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }

    // Setters / Actions
    public function setId(int $id): void { $this->id = $id; }

    public function rename(string $name): void
    {
        $this->name = $name;
    }

    public function __get(string $name): mixed
    {
        $camelCase = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $name))));
        $method = 'get' . ucfirst($camelCase);
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        if (property_exists($this, $camelCase)) {
            return $this->$camelCase;
        }
        return null;
    }
}
