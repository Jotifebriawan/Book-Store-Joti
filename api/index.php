<?php

$storagePath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'book-store-joti';
$viewPath = $storagePath.DIRECTORY_SEPARATOR.'views';

foreach ([$storagePath, $viewPath, $storagePath.DIRECTORY_SEPARATOR.'logs'] as $directory) {
    if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
        throw new RuntimeException("Unable to create runtime directory: {$directory}");
    }
}

$runtimeDefaults = [
    'LARAVEL_STORAGE_PATH' => $storagePath,
    'VIEW_COMPILED_PATH' => $viewPath,
    'APP_CONFIG_CACHE' => $storagePath.DIRECTORY_SEPARATOR.'config.php',
    'APP_EVENTS_CACHE' => $storagePath.DIRECTORY_SEPARATOR.'events.php',
    'APP_PACKAGES_CACHE' => $storagePath.DIRECTORY_SEPARATOR.'packages.php',
    'APP_ROUTES_CACHE' => $storagePath.DIRECTORY_SEPARATOR.'routes.php',
    'APP_SERVICES_CACHE' => $storagePath.DIRECTORY_SEPARATOR.'services.php',
    'CACHE_DRIVER' => 'array',
    'SESSION_DRIVER' => 'cookie',
    'LOG_CHANNEL' => 'stderr',
];

foreach ($runtimeDefaults as $name => $default) {
    $value = getenv($name);

    if ($value === false && isset($_SERVER[$name])) {
        $value = (string) $_SERVER[$name];
    }

    if ($value === false && isset($_ENV[$name])) {
        $value = (string) $_ENV[$name];
    }

    if ($value === false || $value === '') {
        $value = $default;
    }

    $_ENV[$name] = $value;
    $_SERVER[$name] = $value;
    putenv("{$name}={$value}");
}

require __DIR__.'/../public/index.php';
