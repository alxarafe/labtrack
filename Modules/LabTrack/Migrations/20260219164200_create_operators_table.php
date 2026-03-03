<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

/**
 * Migration for creating operators table and importing legacy users.
 */
return new class {
    private string $table = 'operators';
    private string $legacyTable = 'users';

    public function up(): void
    {
        if (!Capsule::schema()->hasTable($this->table)) {
            Capsule::schema()->create($this->table, function (Blueprint $table) {
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
        $connection = Capsule::connection();
        $legacyExists = !empty($connection->select("SHOW TABLES LIKE '{$this->legacyTable}'"));

        if ($legacyExists) {
            $records = $connection->select("SELECT * FROM {$this->legacyTable}");
            foreach ($records as $record) {
                Capsule::table($this->table)->insert([
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
        Capsule::schema()->dropIfExists($this->table);
    }
};
