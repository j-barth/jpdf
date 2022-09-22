<?php

namespace Jbarth;

class PageSize
{
    /** @var float */
    protected $_k;

    /** @var float */
    protected $_width;

    /** @var float */
    protected $_height;

    /** @var string */
    protected $_orientation;

    /** @var int */
    protected $_rotation;

    /** @var float */
    protected $_marginLeft;

    /** @var float */
    protected $_marginTop;

    /** @var float */
    protected $_marginRight;

    /** @var float */
    protected $_marginBottom;

    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        // Scale factor
        if ($unit == PdfFormatEnum::UNIT_PT)
            $this->_k = 1;
        elseif ($unit == PdfFormatEnum::UNIT_MM)
            $this->_k = 72 / 25.4;
        elseif ($unit == PdfFormatEnum::UNIT_CM)
            $this->_k = 72 / 2.54;
        elseif ($unit == PdfFormatEnum::UNIT_IN)
            $this->_k = 72;

        // Page sizes
        $stdPageSizes = [
            'a3' => [841.89, 1190.55],
            'a4' => [595.28, 841.89],
            'a5' => [420.94, 595.28],
            'letter' => [612, 792],
            'legal' => [612, 1008]
        ];
        if (is_string($size)) {
            $size = strtolower($size);
            $a = $stdPageSizes[$size];
            $size = [$a[0] / $this->_k, $a[1] / $this->_k];
        }
        $this->_pageSize = $size;

        // Page orientation
        $orientation = strtolower($orientation);
        if ($orientation == 'p' || $orientation == 'portrait') {
            $this->_orientation = 'P';
            $this->_width = $size[0];
            $this->_height = $size[1];
        } elseif ($orientation == 'l' || $orientation == 'landscape') {
            $this->_orientation = 'L';
            $this->_width = $size[1];
            $this->_height = $size[0];
        }
        // Page rotation
        $this->_rotation = 0;
        // Page margins (1 cm)
        $margin = 28.35 / $this->_k;

        $this->_marginLeft = $margin;
        $this->_marginTop = $margin;
        $this->_marginRight = $margin;

        $this->_marginBottom = 2 * $margin;
    }

    /** @return float[] */
    public function getPageSize(): array
    {
        if ($this->_orientation === 'P') {
            $size = [ $this->_width, $this->_height ];
        } else {
            $size = [ $this->_height, $this->_width ];
        }
        return $size;
    }

    public function getWidthAsPt()
    {
        return $this->_width * $this->_k;
    }

    public function getHeightAsPt()
    {
        return $this->_height * $this->_k;
    }

    public function getWidth()
    {
        return $this->_width;
    }

    public function setWidth($width): void
    {
        $this->_width = $width;
    }

    public function getHeight()
    {
        return $this->_height;
    }

    public function setHeight($height): void
    {
        $this->_height = $height;
    }

    public function getK(): float
    {
        return $this->_k;
    }

    public function setK(float $k): void
    {
        $this->_k = $k;
    }


    /** @param float[] $pageSize */
    public function setPageSize(array $pageSize): void
    {
        $this->_pageSize = $pageSize;
    }

    public function getOrientation(): string
    {
        return $this->_orientation;
    }

    public function setOrientation(string $orientation): void
    {
        $this->_orientation = $orientation;
    }

    public function getRotation(): int
    {
        return $this->_rotation;
    }

    public function setRotation(int $rotation): void
    {
        $this->_rotation = $rotation;
    }

    public function getMarginLeft(): float
    {
        return $this->_marginLeft;
    }

    public function setMarginLeft(float $marginLeft): void
    {
        $this->_marginLeft = $marginLeft;
    }

    public function getMarginTop(): float
    {
        return $this->_marginTop;
    }

    public function setMarginTop(float $marginTop): void
    {
        $this->_marginTop = $marginTop;
    }

    public function getMarginRight(): float
    {
        return $this->_marginRight;
    }

    public function setMarginRight(float $marginRight): void
    {
        $this->_marginRight = $marginRight;
    }

    public function getMarginBottom(): float
    {
        return $this->_marginBottom;
    }

    public function setMarginBottom(float $marginBottom): void
    {
        $this->_marginBottom = $marginBottom;
    }
}
