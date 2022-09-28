<?php

namespace IntegrationTests;

use CoreTests\ResourceLoader;
use CoreTests\TestableFpdfTuto5;
use PHPUnit\Framework\TestCase;

class Tuto5Test extends TestCase
{

    public function testConstructorDefault()
    {
        $pdf = new TestableFpdfTuto5();
        $pdf->SetCompression(false);
        $pdf->specificCreationDate = '20220927204814';

        // Titres des colonnes
        $header = array('Pays', 'Capitale', 'Superficie (km²)', 'Pop. (milliers)');
        // Chargement des données
        $data = $pdf->LoadData(__DIR__ . '/../Resources/text/pays.txt');
        $pdf->SetFont('Arial','',14);
        $pdf->AddPage();
        $pdf->BasicTable($header,$data);
        $pdf->AddPage();
        $pdf->ImprovedTable($header,$data);
        $pdf->AddPage();
        $pdf->FancyTable($header,$data);

        $output = $pdf->Output('F', __DIR__ . '/../Resources/Expected/Tuto5.pdf');
        $output = $pdf->Output('S');

        $resourceLoader = new ResourceLoader();

        $expected = $resourceLoader->getFromResource('Tuto5.pdf');
        $this->assertEquals($expected, $output);
    }
}


