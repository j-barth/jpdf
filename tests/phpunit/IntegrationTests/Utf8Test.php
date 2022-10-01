<?php

namespace IntegrationTests;

use CoreTests\ResourceLoader;
use CoreTests\TestableFpdf;
use PHPUnit\Framework\TestCase;

class Utf8Test extends TestCase
{

    public function testConstructorDefault()
    {

        $pdf = new TestableFpdf();
        $pdf->SetCompression(false);
        $pdf->specificCreationDate = '20220927204814';

        $pdf->AddPage();

        // Add a Unicode font (uses UTF-8)
        $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
        $pdf->SetFont('DejaVu','',14);

        // Load a UTF-8 string from a file and print it
        $txt = file_get_contents(__DIR__ . '/../Resources/text/HelloWorld.txt');
        $pdf->Write(8,$txt);

        // Select a standard font (uses windows-1252)
        $pdf->SetFont('Arial','',14);
        $pdf->Ln(10);
        $pdf->Write(5,'The file size of this PDF is only 13 KB.');

        $output = $pdf->Output('S');

        $resourceLoader = new ResourceLoader();

        $expected = $resourceLoader->getFromResource('utf8.pdf');
        $this->assertEquals($expected, $output);
    }
}