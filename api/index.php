<?php

// =========================================================================
// Vercel Serverless Entry Point for Laravel
// =========================================================================

// Siapkan direktori storage yang dapat ditulisi di /tmp pada lingkungan Vercel
$tmpStorage = '/tmp/storage';
$requiredDirs = [
    $tmpStorage . '/app/public',
    $tmpStorage . '/framework/cache/data',
    $tmpStorage . '/framework/sessions',
    $tmpStorage . '/framework/testing',
    $tmpStorage . '/framework/views',
    $tmpStorage . '/logs',
    '/tmp/bootstrap/cache',
];

foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Redirect cache dan compiled views path ke direktori /tmp
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');
putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/bootstrap/cache/config.php');
putenv('APP_ROUTES_CACHE=/tmp/bootstrap/cache/routes.php');
putenv('VERCEL=1');

$_ENV['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Eksekusi entry point utama publik Laravel
require __DIR__ . '/../public/index.php';
