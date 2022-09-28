<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require_once './vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4('Jbarth\\', __DIR__ . '/../../src');
$classLoader->addPsr4('CoreTests\\', __DIR__ . '/CoreTests');
$classLoader->addPsr4('FastTests\\', __DIR__ . '/FastTests');
$classLoader->addPsr4('IntegrationTests\\', __DIR__ . '/IntegrationTests');
$classLoader->register();
