<?php

/**
 * Migration for creating operators table and importing legacy users.
 */

declare(strict_types=1);

use Alxarafe\Infrastructure\Persistence\Database;
use Illuminate\Database\Schema\Blueprint;

return new class {
    private string $table = 'operators';
    private string $legacyTable = 'users';

    public function up(): void
    {
        if (!Database::schema()->hasTable($this->table)) {
            Database::schema()->create($this->table, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('pin', 10)->unique();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });

            $this->importLegacyData();
        }
    }

    private function importLegacyData(): void
    {
        // We check for the legacy table without prefix
        $connection = Database::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyTable}");
            foreach ($records as $record) {
                Database::table($this->table)->insert([
                    'id' => $record->id,
                    'name' => $record->username,
                    'pin' => $record->fastaccess,
                    'user_id' => null, // Will be linked manually or during transition
                    'active' => (bool)$record->active,
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
