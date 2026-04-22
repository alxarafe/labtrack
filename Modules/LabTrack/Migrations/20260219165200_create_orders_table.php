<?php

/**
 * Migration for orders.
 */

declare(strict_types=1);

use Alxarafe\Infrastructure\Persistence\Database;
use Illuminate\Database\Schema\Blueprint;

return new class {
    private string $table = 'orders';
    private string $legacyTable = 'ordenes';

    public function up(): void
    {
        if (!Database::schema()->hasTable($this->table)) {
            Database::schema()->create($this->table, function (Blueprint $table) {
                $table->id();
                $table->string('name');
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
                    'name' => $record->nombre,
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
