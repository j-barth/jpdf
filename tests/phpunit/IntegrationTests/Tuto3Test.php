<?php

namespace IntegrationTests;

use CoreTests\ResourceLoader;
use CoreTests\TestableFpdfTuto3;
use PHPUnit\Framework\TestCase;

class Tuto3Test extends TestCase
{

    public function testConstructorDefault()
    {
        $pdf = new TestableFpdfTuto3();
        $pdf->SetCompression(false);
        $pdf->specificCreationDate = '20220927204814';

        global $titre;

        $titre = 'Vingt mille lieues sous les mers';
        $pdf->SetTitle($titre);
        $pdf->SetAuthor('Jules Verne');
        $pdf->AjouterChapitre(1,'UN ?CUEIL FUYANT',__DIR__ . '/../Resources/text/20k_c1.txt');
        $pdf->AjouterChapitre(2,'LE POUR ET LE CONTRE',__DIR__ . '/../Resources/text/20k_c2.txt');

        $output = $pdf->Output('S');

        $resourceLoader = new ResourceLoader();

        $expected = $resourceLoader->getFromResource('Tuto3.pdf');
        $this->assertEquals($expected, $output);
    }
}


