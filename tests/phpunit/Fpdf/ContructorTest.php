<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class ContructorTest extends TestCase
{

    public function testConstructorDefault()
    {
        $fpdf = new TestableFpdf();

        $this->assertEquals(0, $fpdf->getParam('state'));
        $this->assertEquals(0, $fpdf->getParam('page'));
        $this->assertEquals(2, $fpdf->getParam('n'));
        $this->assertEquals('', $fpdf->getParam('buffer'));
        $this->assertIsArray($fpdf->getParam('pages'));
        $this->assertIsArray($fpdf->getParam('PageInfo'));
        $this->assertIsArray($fpdf->getParam('fonts'));
        $this->assertIsArray($fpdf->getParam('FontFiles'));
        $this->assertIsArray($fpdf->getParam('encodings'));
        $this->assertIsArray($fpdf->getParam('cmaps'));
        $this->assertIsArray($fpdf->getParam('images'));
        $this->assertIsArray($fpdf->getParam('links'));
        $this->assertFalse($fpdf->getParam('InHeader'));
        $this->assertFalse($fpdf->getParam('InFooter'));
        $this->assertFalse($fpdf->getParam('underline'));
        $this->assertFalse($fpdf->getParam('ColorFlag'));
        $this->assertFalse($fpdf->getParam('WithAlpha'));
        $this->assertEquals(0, $fpdf->getParam('lasth'));
        $this->assertEquals('', $fpdf->getParam('FontFamily'));
        $this->assertEquals('', $fpdf->getParam('FontStyle'));
        $this->assertEquals(12, $fpdf->getParam('FontSizePt'));
        $this->assertEquals('0 G', $fpdf->getParam('DrawColor'));
        $this->assertEquals('0 g', $fpdf->getParam('FillColor'));
        $this->assertEquals('0 g', $fpdf->getParam('TextColor'));
        $this->assertEquals('0', $fpdf->getParam('ws'));
        $this->assertTrue(is_dir($fpdf->getParam('fontpath')), 'Font path is correctly defined');
        $fontPath = str_replace('tests/phpunit/Fpdf', 'src/font/', dirname(__FILE__));
        $this->assertEquals($fontPath, $fpdf->getParam('fontpath'));

        $expectedCoreFonts = ['courier', 'helvetica', 'times', 'symbol', 'zapfdingbats'];
        $actualCoreFonts = $fpdf->getParam('CoreFonts');
        $this->assertEquals($expectedCoreFonts, $actualCoreFonts);

        $excpectedK = 72 / 25.4;

        $this->assertEquals($excpectedK, $fpdf->getParam('k'));

        $stdPageSizes = array('a3' => array(841.89, 1190.55), 'a4' => array(595.28, 841.89), 'a5' => array(420.94, 595.28),
            'letter' => array(612, 792), 'legal' => array(612, 1008));
        $this->assertEquals($stdPageSizes, $fpdf->getParam('StdPageSizes'));

        $pageSize = $stdPageSizes['a4'];
        $expectedSize = array_map(function(float $size) use($excpectedK): float { return $size / $excpectedK; }, $pageSize);
        $this->assertEquals($expectedSize, $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedSize, $fpdf->getParam('CurPageSize'));

        $this->assertEquals('P', $fpdf->getParam('DefOrientation'));
        $this->assertEquals($expectedSize[0], $fpdf->getParam('w'));
        $this->assertEquals($expectedSize[1], $fpdf->getParam('h'));
        $this->assertEquals('P', $fpdf->getParam('CurOrientation'));
        $this->assertEquals($pageSize[0], $fpdf->getParam('wPt'));
        $this->assertEquals($pageSize[1], $fpdf->getParam('hPt'));
        $this->assertEquals(0, $fpdf->getParam('CurRotation'));

        $excpectedMargin = 28.35 / $excpectedK;
        $this->assertEquals($excpectedMargin, $fpdf->getParam('lMargin'));
        $this->assertEquals($excpectedMargin, $fpdf->getParam('tMargin'));
        $this->assertEquals($excpectedMargin, $fpdf->getParam('rMargin'));
        $this->assertEquals($excpectedMargin / 10, $fpdf->getParam('cMargin'));

        $this->assertEquals(.567  / $excpectedK, $fpdf->getParam('LineWidth'));

        $this->assertTrue($fpdf->getParam('AutoPageBreak'));
        $this->assertEquals($excpectedMargin * 2, $fpdf->getParam('bMargin'));
        $this->assertEquals($expectedSize[1] - ($excpectedMargin * 2), $fpdf->getParam('PageBreakTrigger'));

        $this->assertEquals('default', $fpdf->getParam('ZoomMode'));
        $this->assertEquals('default', $fpdf->getParam('LayoutMode'));
        $this->assertTrue($fpdf->getParam('compress'));
        $this->assertEquals('1.3', $fpdf->getParam('PDFVersion'));
    }
}


