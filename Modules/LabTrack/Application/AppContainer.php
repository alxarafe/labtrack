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

namespace Modules\LabTrack\Application;

use Alxarafe\Infrastructure\Container\ServiceContainer;
use Alxarafe\Domain\Port\Driven\PersistencePort;
use Alxarafe\Infrastructure\Adapter\Persistence\PdoMysqlAdapter;
use Alxarafe\Infrastructure\Persistence\Config;
use Alxarafe\Application\Bus\SimpleCommandBus;
use Modules\LabTrack\Domain\Port\Driven\MovementRepositoryInterface;
use Modules\LabTrack\Domain\Port\Driven\WorkOrderRepositoryInterface;
use Modules\LabTrack\Infrastructure\Adapter\Persistence\PdoMovementRepository;
use Modules\LabTrack\Infrastructure\Adapter\Persistence\PdoWorkOrderRepository;
use Modules\LabTrack\Application\Bus\Command\RecordMovementCommand;
use Modules\LabTrack\Application\Bus\Command\CreateOrderCommand;
use Modules\LabTrack\Application\Bus\Handler\RecordMovementHandler;
use Modules\LabTrack\Application\Bus\Handler\CreateOrderHandler;

class AppContainer
{
    private static ?ServiceContainer $instance = null;

    public static function get(): ServiceContainer
    {
        if (self::$instance === null) {
            $container = new ServiceContainer();

            // Setup Persistence Port
            $container->singleton(PersistencePort::class, function () {
                $dbConfig = Config::getConfig()->db;
                return PdoMysqlAdapter::fromConfig($dbConfig);
            });

            // Repositories
            $container->singleton(MovementRepositoryInterface::class, function ($c) {
                return new PdoMovementRepository($c->get(PersistencePort::class));
            });

            $container->singleton(WorkOrderRepositoryInterface::class, function ($c) {
                return new PdoWorkOrderRepository($c->get(PersistencePort::class));
            });

            // Command Bus
            $container->singleton(SimpleCommandBus::class, function ($c) {
                $bus = new SimpleCommandBus();
                $bus->registerCommand(
                    RecordMovementCommand::class,
                    new RecordMovementHandler($c->get(MovementRepositoryInterface::class))
                );
                $bus->registerCommand(
                    CreateOrderCommand::class,
                    new CreateOrderHandler($c->get(WorkOrderRepositoryInterface::class))
                );
                return $bus;
            });

            self::$instance = $container;
        }

        return self::$instance;
    }
}
