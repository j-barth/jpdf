<?php
namespace FastTests;

use CoreTests\TestableFpdf;
use Jbarth\PageSize;
use Jbarth\PdfFormatEnum;
use PHPUnit\Framework\TestCase;

class ConstructorTest extends TestCase
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

        $expectedCoreFonts = ['courier', 'helvetica', 'times', 'symbol', 'zapfdingbats'];
        $actualCoreFonts = $fpdf->getParam('CoreFonts');
        $this->assertEquals($expectedCoreFonts, $actualCoreFonts);

        $stdPageSizes = array('a3' => array(841.89, 1190.55), 'a4' => array(595.28, 841.89), 'a5' => array(420.94, 595.28),
            'letter' => array(612, 792), 'legal' => array(612, 1008));
        $this->assertEquals($stdPageSizes, $fpdf->getParam('StdPageSizes'));

        $expectedPageSize = new PageSize();


        $this->assertEquals($expectedPageSize->getK(), $fpdf->getParam('k'));

        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));

        $this->assertEquals($expectedPageSize->getOrientation(), $fpdf->getParam('DefOrientation'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getOrientation(), $fpdf->getParam('CurOrientation'));
        $this->assertEquals($expectedPageSize->getWidthAsPt(), $fpdf->getParam('wPt'));
        $this->assertEquals($expectedPageSize->getHeightAsPt(), $fpdf->getParam('hPt'));
        $this->assertEquals($expectedPageSize->getRotation(), $fpdf->getParam('CurRotation'));

        $this->assertEquals($expectedPageSize->getMarginLeft(), $fpdf->getParam('lMargin'));
        $this->assertEquals($expectedPageSize->getMarginTop(), $fpdf->getParam('tMargin'));
        $this->assertEquals($expectedPageSize->getMarginRight(), $fpdf->getParam('rMargin'));
        $this->assertEquals($expectedPageSize->getMarginBottom(), $fpdf->getParam('bMargin'));

        $excpectedCMargin = (28.35 / $expectedPageSize->getK()) / 10;
        $this->assertEquals($excpectedCMargin, $fpdf->getParam('cMargin'));

        $this->assertEquals(.567  / $expectedPageSize->getK(), $fpdf->getParam('LineWidth'));

        $this->assertTrue($fpdf->getParam('AutoPageBreak'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $this->assertEquals('default', $fpdf->getParam('ZoomMode'));
        $this->assertEquals('default', $fpdf->getParam('LayoutMode'));
        $this->assertTrue($fpdf->getParam('compress'));
        $this->assertEquals('1.3', $fpdf->getParam('PDFVersion'));
    }

    public function testConstructorLandscape()
    {
        $fpdf = new TestableFpdf('L');
        $expectedPageSize = new PageSize('L');
        $this->assertEquals($expectedPageSize->getOrientation(), $fpdf->getParam('DefOrientation'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getOrientation(), $fpdf->getParam('CurOrientation'));
        $this->assertEquals($expectedPageSize->getWidthAsPt(), $fpdf->getParam('wPt'));
        $this->assertEquals($expectedPageSize->getHeightAsPt(), $fpdf->getParam('hPt'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

    }

    public function testConstructorUnitK()
    {
        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_CM);
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_CM);
        $this->assertEquals($expectedPageSize->getK(), $fpdf->getParam('k'), 'error on k');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getMarginLeft(), $fpdf->getParam('lMargin'));
        $this->assertEquals($expectedPageSize->getMarginTop(), $fpdf->getParam('tMargin'));
        $this->assertEquals($expectedPageSize->getMarginRight(), $fpdf->getParam('rMargin'));
        $this->assertEquals($expectedPageSize->getMarginBottom(), $fpdf->getParam('bMargin'));
        $excpectedCMargin = (28.35 / $expectedPageSize->getK()) / 10;
        $this->assertEquals($excpectedCMargin, $fpdf->getParam('cMargin'));
        $this->assertEquals(.567  / $expectedPageSize->getK(), $fpdf->getParam('LineWidth'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('L', PdfFormatEnum::UNIT_CM);
        $expectedPageSize = new PageSize('L', PdfFormatEnum::UNIT_CM);
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_IN);
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_IN);
        $this->assertEquals($expectedPageSize->getK(), $fpdf->getParam('k'), 'error on k');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getMarginLeft(), $fpdf->getParam('lMargin'));
        $this->assertEquals($expectedPageSize->getMarginTop(), $fpdf->getParam('tMargin'));
        $this->assertEquals($expectedPageSize->getMarginRight(), $fpdf->getParam('rMargin'));
        $this->assertEquals($expectedPageSize->getMarginBottom(), $fpdf->getParam('bMargin'));
        $excpectedCMargin = (28.35 / $expectedPageSize->getK()) / 10;
        $this->assertEquals($excpectedCMargin, $fpdf->getParam('cMargin'));
        $this->assertEquals(.567  / $expectedPageSize->getK(), $fpdf->getParam('LineWidth'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('L', PdfFormatEnum::UNIT_IN);
        $expectedPageSize = new PageSize('L', PdfFormatEnum::UNIT_IN);
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_PT);
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_PT);
        $this->assertEquals($expectedPageSize->getK(), $fpdf->getParam('k'), 'error on k');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getMarginLeft(), $fpdf->getParam('lMargin'));
        $this->assertEquals($expectedPageSize->getMarginTop(), $fpdf->getParam('tMargin'));
        $this->assertEquals($expectedPageSize->getMarginRight(), $fpdf->getParam('rMargin'));
        $this->assertEquals($expectedPageSize->getMarginBottom(), $fpdf->getParam('bMargin'));
        $excpectedCMargin = (28.35 / $expectedPageSize->getK()) / 10;
        $this->assertEquals($excpectedCMargin, $fpdf->getParam('cMargin'));
        $this->assertEquals(.567  / $expectedPageSize->getK(), $fpdf->getParam('LineWidth'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('L', PdfFormatEnum::UNIT_PT);
        $expectedPageSize = new PageSize('L', PdfFormatEnum::UNIT_PT);
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_MM);
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_MM);
        $this->assertEquals($expectedPageSize->getK(), $fpdf->getParam('k'), 'error on k');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getMarginLeft(), $fpdf->getParam('lMargin'));
        $this->assertEquals($expectedPageSize->getMarginTop(), $fpdf->getParam('tMargin'));
        $this->assertEquals($expectedPageSize->getMarginRight(), $fpdf->getParam('rMargin'));
        $this->assertEquals($expectedPageSize->getMarginBottom(), $fpdf->getParam('bMargin'));
        $excpectedCMargin = (28.35 / $expectedPageSize->getK()) / 10;
        $this->assertEquals($excpectedCMargin, $fpdf->getParam('cMargin'));
        $this->assertEquals(.567  / $expectedPageSize->getK(), $fpdf->getParam('LineWidth'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('L', PdfFormatEnum::UNIT_MM);
        $expectedPageSize = new PageSize('L', PdfFormatEnum::UNIT_MM);
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));
    }


    public function testConstructorPageSize()
    {
        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_MM, 'A3');
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_MM, 'A3');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getWidthAsPt(), $fpdf->getParam('wPt'));
        $this->assertEquals($expectedPageSize->getHeightAsPt(), $fpdf->getParam('hPt'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_MM, 'A5');
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_MM, 'A5');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getWidthAsPt(), $fpdf->getParam('wPt'));
        $this->assertEquals($expectedPageSize->getHeightAsPt(), $fpdf->getParam('hPt'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_MM, 'letter');
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_MM, 'letter');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getWidthAsPt(), $fpdf->getParam('wPt'));
        $this->assertEquals($expectedPageSize->getHeightAsPt(), $fpdf->getParam('hPt'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

        $fpdf = new TestableFpdf('P', PdfFormatEnum::UNIT_MM, 'legal');
        $expectedPageSize = new PageSize('P', PdfFormatEnum::UNIT_MM, 'legal');
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('DefPageSize'));
        $this->assertEquals($expectedPageSize->getPageSize(), $fpdf->getParam('CurPageSize'));
        $this->assertEquals($expectedPageSize->getWidth(), $fpdf->getParam('w'));
        $this->assertEquals($expectedPageSize->getHeight(), $fpdf->getParam('h'));
        $this->assertEquals($expectedPageSize->getWidthAsPt(), $fpdf->getParam('wPt'));
        $this->assertEquals($expectedPageSize->getHeightAsPt(), $fpdf->getParam('hPt'));
        $this->assertEquals($expectedPageSize->getHeight() - $expectedPageSize->getMarginBottom(), $fpdf->getParam('PageBreakTrigger'));

    }
}


