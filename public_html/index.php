<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use Alxarafe\Tools\Dispatcher\WebDispatcher;
use Alxarafe\Base\Config;
use Alxarafe\Lib\Trans;

// Step 1: Core Path and Environment definitions
define('APP_PATH', realpath(__DIR__ . '/../'));
define('BASE_PATH', __DIR__);
define('PUBLIC_DIR', basename(BASE_PATH));
define('ALX_PATH', APP_PATH . '/vendor/alxarafe/alxarafe');

$config = Config::getConfig();

// --- Stability Guardian: If no config exists, redirect to the Installation/Config page ---
if (!$config && (($_GET['controller'] ?? '') !== 'Config')) {
    header('Location: index.php?module=Admin&controller=Config');
    exit;
}

// Determine BASE_URL for the app
if (!defined('BASE_URL')) {
    $baseUrl = $config->main->url ?? null;
    if (!$baseUrl && isset($_SERVER['HTTP_HOST'])) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $baseUrl = "{$protocol}://{$_SERVER['HTTP_HOST']}";
    }
    define('BASE_URL', rtrim($baseUrl ?? 'http://localhost', '/'));
}

class_alias(\Illuminate\Support\Str::class, 'Str');

// Step 3: Global Branding and Testing overrides
if ($config && isset($config->main)) {
    $config->main->appName = 'LabTrack';
    $config->main->appIcon = 'fas fa-microscope';

    // We define the active theme for the ThemeManager and other framework components
    define('THEME_SKIN', $config->main->theme);

    // Step 4: Initialize Database connection
    if ($config && isset($config->db)) {
        \Alxarafe\Base\Database::createConnection($config->db);
    }
}

// Step 4: Run the Application!
WebDispatcher::dispatch('LabTrack', 'Main', 'index');
