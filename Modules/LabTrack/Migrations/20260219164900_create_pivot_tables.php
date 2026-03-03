<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * Migration for pivot tables.
 */
return new class {
    private string $fpTable = 'family_process';
    private string $psTable = 'process_sequence';

    // Legacy tables (no prefix)
    private string $legacyFpTable = 'familias_procesos';
    private string $legacyPsTable = 'procesos_secuencias';

    public function up(): void
    {
        if (!Capsule::schema()->hasTable($this->fpTable)) {
            Capsule::schema()->create($this->fpTable, function (Blueprint $table) {
                $table->unsignedBigInteger('family_id');
                $table->unsignedBigInteger('process_id');
                $table->primary(['family_id', 'process_id']);
            });
            $this->importFpLegacy();
        }

        if (!Capsule::schema()->hasTable($this->psTable)) {
            Capsule::schema()->create($this->psTable, function (Blueprint $table) {
                $table->unsignedBigInteger('process_id');
                $table->unsignedBigInteger('sequence_id');
                $table->primary(['process_id', 'sequence_id']);
            });
            $this->importPsLegacy();
        }
    }

    private function importFpLegacy(): void
    {
        $connection = Capsule::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyFpTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyFpTable}");
            foreach ($records as $record) {
                Capsule::table($this->fpTable)->insert([
                    'family_id' => $record->id_familia,
                    'process_id' => $record->id_proceso,
                ]);
            }
        }
    }

    private function importPsLegacy(): void
    {
        $connection = Capsule::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyPsTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyPsTable}");
            foreach ($records as $record) {
                Capsule::table($this->psTable)->insert([
                    'process_id' => $record->id_proceso,
                    'sequence_id' => $record->id_secuencia,
                ]);
            }
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists($this->fpTable);
        Capsule::schema()->dropIfExists($this->psTable);
    }
};
