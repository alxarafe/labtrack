<?php

declare(strict_types=1);

namespace Modules\LabTrack\Seeders;

use Alxarafe\Infrastructure\Persistence\Database;

class CsvSeeder
{
    public function __construct()
    {
        $this->run();
    }

    public function run(): void
    {
        $importDir = constant('APP_PATH') . '/import/';
        if (!is_dir($importDir)) {
            return;
        }

        // Cost Centers
        if (file_exists($importDir . 'centroscosto.csv') && Database::table('cost_centers')->count() === 0) {
            $data = $this->readCsv($importDir . 'centroscosto.csv');
            foreach ($data as $row) {
                if (!isset($row[0], $row[1], $row[2])) {
                    continue;
                }
                Database::table('cost_centers')->insert([
                    'id' => (int)$row[0],
                    'name' => $row[1],
                    'active' => $row[2] === '1',
                    'sort_order' => (int)$row[0] * 10,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        // Families
        if (file_exists($importDir . 'familias.csv') && Database::table('families')->count() === 0) {
            $data = $this->readCsv($importDir . 'familias.csv');
            foreach ($data as $row) {
                if (!isset($row[0], $row[1], $row[2], $row[3])) {
                    continue;
                }
                Database::table('families')->insert([
                    'id' => (int)$row[0],
                    'cost_center_id' => (int)$row[1],
                    'name' => $row[2],
                    'active' => $row[3] === '1',
                    'sort_order' => (int)$row[0] * 10,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        // Processes
        if (file_exists($importDir . 'procesos.csv')) {
            $data = $this->readCsv($importDir . 'procesos.csv');
            foreach ($data as $row) {
                if (!isset($row[0], $row[1], $row[2], $row[3])) {
                    continue;
                }

                // Insert process if not exists
                if (Database::table('processes')->where('id', (int)$row[0])->count() === 0) {
                    Database::table('processes')->insert([
                        'id' => (int)$row[0],
                        'name' => $row[2],
                        'active' => $row[3] === '1',
                        'sort_order' => (int)$row[0] * 10,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }

                // Insert Pivot family_process
                $exists = Database::table('family_process')
                    ->where('family_id', (int)$row[1])
                    ->where('process_id', (int)$row[0])
                    ->count() === 0;
                if ($exists) {
                    Database::table('family_process')->insert([
                        'family_id' => (int)$row[1],
                        'process_id' => (int)$row[0],
                    ]);
                }
            }
        }

        // Sequences
        if (file_exists($importDir . 'secuencias.csv')) {
            $data = $this->readCsv($importDir . 'secuencias.csv');
            foreach ($data as $row) {
                if (!isset($row[0], $row[1], $row[2], $row[3], $row[4])) {
                    continue;
                }

                // Insert sequence if not exists
                if (Database::table('sequences')->where('id', (int)$row[0])->count() === 0) {
                    Database::table('sequences')->insert([
                        'id' => (int)$row[0],
                        'name' => $row[2],
                        'active' => $row[3] === '1',
                        'duration_minutes' => (int)$row[4],
                        'duration_editable' => isset($row[5]) && $row[5] === '1',
                        'sort_order' => (int)$row[0] * 10,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }

                // Insert Pivot process_sequence
                $exists = Database::table('process_sequence')
                    ->where('process_id', (int)$row[1])
                    ->where('sequence_id', (int)$row[0])
                    ->count() === 0;
                if ($exists) {
                    Database::table('process_sequence')->insert([
                        'process_id' => (int)$row[1],
                        'sequence_id' => (int)$row[0],
                    ]);
                }
            }
        }
    }

    private function readCsv(string $file): array
    {
        $rows = [];
        if (($handle = fopen($file, "r")) !== false) {
            // Skip header
            fgetcsv($handle, 1000, ";");
            while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }
        return $rows;
    }
}
