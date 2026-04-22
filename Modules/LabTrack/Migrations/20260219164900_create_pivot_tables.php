<?php

/**
 * Migration for pivot tables.
 */

declare(strict_types=1);

use Alxarafe\Infrastructure\Persistence\Database;
use Illuminate\Database\Schema\Blueprint;

return new class {
    private string $fpTable = 'family_process';
    private string $psTable = 'process_sequence';

    // Legacy tables (no prefix)
    private string $legacyFpTable = 'familias_procesos';
    private string $legacyPsTable = 'procesos_secuencias';

    public function up(): void
    {
        if (!Database::schema()->hasTable($this->fpTable)) {
            Database::schema()->create($this->fpTable, function (Blueprint $table) {
                $table->unsignedBigInteger('family_id');
                $table->unsignedBigInteger('process_id');
                $table->primary(['family_id', 'process_id']);
            });
            $this->importFpLegacy();
        }

        if (!Database::schema()->hasTable($this->psTable)) {
            Database::schema()->create($this->psTable, function (Blueprint $table) {
                $table->unsignedBigInteger('process_id');
                $table->unsignedBigInteger('sequence_id');
                $table->primary(['process_id', 'sequence_id']);
            });
            $this->importPsLegacy();
        }
    }

    private function importFpLegacy(): void
    {
        $connection = Database::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyFpTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyFpTable}");
            foreach ($records as $record) {
                Database::table($this->fpTable)->insert([
                    'family_id' => $record->id_familia,
                    'process_id' => $record->id_proceso,
                ]);
            }
        }
    }

    private function importPsLegacy(): void
    {
        $connection = Database::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyPsTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyPsTable}");
            foreach ($records as $record) {
                Database::table($this->psTable)->insert([
                    'process_id' => $record->id_proceso,
                    'sequence_id' => $record->id_secuencia,
                ]);
            }
        }
    }

    public function down(): void
    {
        Database::schema()->dropIfExists($this->fpTable);
        Database::schema()->dropIfExists($this->psTable);
    }
};
