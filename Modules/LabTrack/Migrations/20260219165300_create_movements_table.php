<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * Migration for movements.
 */
return new class {
    private string $table = 'movements';
    private string $legacyTable = 'movimientos';

    public function up(): void
    {
        if (!Capsule::schema()->hasTable($this->table)) {
            Capsule::schema()->create($this->table, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('operator_id');
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('cost_center_id');
                $table->unsignedBigInteger('family_id');
                $table->unsignedBigInteger('process_id');
                $table->unsignedBigInteger('sequence_id');
                $table->integer('units')->default(1);
                $table->integer('duration_minutes')->default(0);
                $table->text('notes')->nullable();
                $table->dateTime('movement_at');
                $table->unsignedBigInteger('supervised_by')->nullable();

                $table->index('operator_id');
                $table->index('order_id');
                $table->index('movement_at');
            });

            $this->importLegacyData();
        }
    }

    private function importLegacyData(): void
    {
        $connection = Capsule::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyTable}");
            foreach ($records as $record) {
                Capsule::table($this->table)->insert([
                    'id' => $record->id,
                    'operator_id' => (int)$record->id_operador,
                    'order_id' => (int)$record->id_orden,
                    'cost_center_id' => (int)$record->id_centrocosto,
                    'family_id' => (int)$record->id_familia,
                    'process_id' => (int)$record->id_proceso,
                    'sequence_id' => (int)$record->id_secuencia,
                    'units' => (int)$record->unidades,
                    'duration_minutes' => (int)$record->duracion,
                    'notes' => $record->notas,
                    'movement_at' => $record->hora,
                    'supervised_by' => (int)$record->supervisado ?: null,
                ]);
            }
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists($this->table);
    }
};
