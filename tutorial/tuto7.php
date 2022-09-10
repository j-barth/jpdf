<?php
define('FPDF_FONTPATH','.');

require_once '../vendor/autoload.php';
$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4('Jbarth\\', __DIR__ . '/../src');
$classLoader->register();


$pdf = new  Jbarth\Fpdf();
$pdf->AddFont('CevicheOne','','CevicheOne-Regular.php');
$pdf->AddPage();
$pdf->SetFont('CevicheOne','',45);
$pdf->Cell(0,10,'Changez de police avec FPDF !');
$pdf->Output();
