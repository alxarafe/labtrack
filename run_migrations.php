<?php

require __DIR__ . '/vendor/autoload.php';

use Alxarafe\Base\Config;

// Define paths
define('APP_PATH', __DIR__);
define('BASE_PATH', APP_PATH . '/public_html');
define('ALX_PATH', APP_PATH . '/vendor/alxarafe/alxarafe');

echo "Running Alxarafe Migrations...\n";

try {
    $result = Config::doRunMigrations();
    if ($result) {
        echo "Migrations executed successfully!\n";

        echo "Running Seeders...\n";
        $seedResult = Config::runSeeders();
        if ($seedResult) {
            echo "Seeders executed successfully!\n";
        } else {
            echo "Error running seeders.\n";
        }
    } else {
        echo "Error running migrations.\n";
    }
} catch (Throwable $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
