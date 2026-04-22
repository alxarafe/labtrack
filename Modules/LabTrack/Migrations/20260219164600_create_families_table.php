<?php

/**
 * Migration for families.
 */

declare(strict_types=1);

use Alxarafe\Infrastructure\Persistence\Database;
use Illuminate\Database\Schema\Blueprint;

return new class {
    private string $table = 'families';
    private string $legacyTable = 'familias';

    public function up(): void
    {
        if (!Database::schema()->hasTable($this->table)) {
            Database::schema()->create($this->table, function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('cost_center_id');
                $table->integer('sort_order')->default(0);
                $table->string('name');
                $table->string('button_text')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });

            $this->importLegacyData();
        }
    }

    private function importLegacyData(): void
    {
        $connection = Database::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyTable}");
            foreach ($records as $record) {
                Database::table($this->table)->insert([
                    'id' => $record->id,
                    'cost_center_id' => (int)$record->id_centro,
                    'sort_order' => (int)$record->orden,
                    'name' => $record->nombre,
                    'button_text' => $record->nombre_boton,
                    'active' => (bool)$record->estado,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

    public function down(): void
    {
        Database::schema()->dropIfExists($this->table);
    }
};
