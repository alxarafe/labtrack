<?php

require __DIR__ . '/vendor/autoload.php';

use Alxarafe\Base\Config;
use Alxarafe\Base\Database;
use Illuminate\Database\Capsule\Manager as Capsule;

// Define paths
define('APP_PATH', __DIR__);
define('BASE_PATH', APP_PATH . '/public_html');

echo "Adjusting Admin Password...\n";

try {
    $config = Config::getConfig();
    if ($config && isset($config->db)) {
        Database::createConnection($config->db);
    }

    $password = password_hash('admin123', PASSWORD_DEFAULT);

    // We update using Capsule directly to avoid model namespace issues or side effects
    $updated = Capsule::table('users')->where('name', 'admin')->update([
        'password' => $password
    ]);

    if ($updated) {
        echo "Password for user 'admin' has been reset to 'admin123'.\n";
    } else {
        echo "User 'admin' not found or password already matches.\n";
    }
} catch (Throwable $e) {
    echo "Fatal Error: " . $e->getMessage() . "\n";
}
