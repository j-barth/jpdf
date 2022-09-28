<?php

namespace IntegrationTests;

use CoreTests\ResourceLoader;
use CoreTests\TestableFpdfTuto6;
use PHPUnit\Framework\TestCase;

class Tuto6Test extends TestCase
{

    public function testConstructorDefault()
    {

        $html = 'Vous pouvez maintenant imprimer facilement du texte m�langeant diff�rents styles : <b>gras</b>, '
              .'<i>italique</i>, <u>soulign�</u>, ou <b><i><u>tous � la fois</u></i></b> !<br><br>Vous pouvez aussi '
              .'ins�rer des liens sous forme textuelle, comme <a href="http://www.fpdf.org">www.fpdf.org</a>, ou bien '
              .'sous forme d\'image : cliquez sur le logo.';

        $pdf = new TestableFpdfTuto6();
        $pdf->SetCompression(false);
        $pdf->specificCreationDate = '20220927204814';

        // Premi�re page
        $pdf->AddPage();
        $pdf->SetFont('Arial','',20);
        $pdf->Write(5,'Pour d�couvrir les nouveaut�s de ce tutoriel, cliquez ');
        $pdf->SetFont('','U');
        $link = $pdf->AddLink();
        $pdf->Write(5,'ici',$link);
        $pdf->SetFont('');
        // Seconde page
        $pdf->AddPage();
        $pdf->SetLink($link);
        $pdf->Image(__DIR__ . '/../Resources/img/logo.png',10,12,30,0,'','http://www.fpdf.org');
        $pdf->SetLeftMargin(45);
        $pdf->SetFontSize(14);
        $pdf->WriteHTML($html);

        $output = $pdf->Output('S');

        $resourceLoader = new ResourceLoader();

        $expected = $resourceLoader->getFromResource('Tuto6.pdf');
        $this->assertEquals($expected, $output);
    }
}


