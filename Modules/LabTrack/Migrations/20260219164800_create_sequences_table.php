<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * Migration for sequences.
 */
return new class {
    private string $table = 'sequences';
    private string $legacyTable = 'secuencias';

    public function up(): void
    {
        if (!Capsule::schema()->hasTable($this->table)) {
            Capsule::schema()->create($this->table, function (Blueprint $table) {
                $table->id();
                $table->integer('sort_order')->default(0);
                $table->string('name');
                $table->string('button_text')->nullable();
                $table->integer('duration_minutes')->default(0);
                $table->boolean('duration_editable')->default(false);
                $table->boolean('active')->default(true);
                $table->timestamps();
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
                    'sort_order' => (int)$record->orden,
                    'name' => $record->nombre,
                    'button_text' => $record->nombre_boton,
                    'duration_minutes' => (int)$record->duracion,
                    'duration_editable' => (bool)$record->duracion_editable,
                    'active' => (bool)$record->estado,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function down(): void
    {
        Capsule::schema()->dropIfExists($this->table);
    }
};
