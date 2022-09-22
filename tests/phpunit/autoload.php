<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

require_once './vendor/autoload.php';

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4('Jbarth\\', __DIR__ . '/../../src');
$classLoader->addPsr4('Tests\\', __DIR__ . '/Fpdf');
$classLoader->register();
