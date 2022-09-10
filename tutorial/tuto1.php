<?php

require_once '../vendor/autoload.php';
$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4('Jbarth\\', __DIR__ . '/../src');
$classLoader->register();

$pdf = new \Jbarth\Fpdf();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World !');
$pdf->Output();