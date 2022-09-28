<?php

namespace IntegrationTests;

use CoreTests\ResourceLoader;
use CoreTests\TestableFpdf;
use CoreTests\TestableFpdfTuto2;
use PHPUnit\Framework\TestCase;

class Tuto2Test extends TestCase
{

    public function testConstructorDefault()
    {
        $pdf = new TestableFpdfTuto2();
        $pdf->SetCompression(false);
        $pdf->specificCreationDate = '20220927204814';
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        for ($i = 1; $i <= 40; $i++)
            $pdf->Cell(0, 10, 'Impression de la ligne numéro ' . $i, 0, 1);
        $output = $pdf->Output('S');

        $resourceLoader = new ResourceLoader();

        $expected = $resourceLoader->getFromResource('Tuto2.pdf');
        $this->assertEquals($expected, $output);
    }
}


