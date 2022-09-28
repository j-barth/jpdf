<?php

namespace IntegrationTests;

use CoreTests\ResourceLoader;
use CoreTests\TestableFpdf;
use PHPUnit\Framework\TestCase;

class Tuto7Test extends TestCase
{

    public function testConstructorDefault()
    {

        $pdf = new TestableFpdf();
        $pdf->SetCompression(false);
        $pdf->specificCreationDate = '20220927204814';

        $pdf->AddFont('CevicheOne','','CevicheOne-Regular.php');
        $pdf->AddPage();
        $pdf->SetFont('CevicheOne','',45);
        $pdf->Cell(0,10,'Changez de police avec FPDF !');

        $output = $pdf->Output('S');

        $resourceLoader = new ResourceLoader();

        $expected = $resourceLoader->getFromResource('Tuto7.pdf');
        $this->assertEquals($expected, $output);
    }
}


