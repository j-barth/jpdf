<?php
namespace IntegrationTests;

use CoreTests\ResourceLoader;
use CoreTests\TestableFpdf;
use PHPUnit\Framework\TestCase;

class Tuto1Test extends TestCase
{

    public function testConstructorDefault()
    {
        $pdf = new TestableFpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World !');
        $pdf->SetCompression(false);
        $pdf->specificCreationDate = '20220927204814';
        $output = $pdf->Output('S');

        $resourceLoader = new ResourceLoader();

        $expected = $resourceLoader->getFromResource('Tuto1.pdf');
        $this->assertEquals($expected, $output);
    }
}


