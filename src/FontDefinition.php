<?php

namespace Jbarth;


class FontDefinition
{

    /** @var string */
    public $font;

    /** @var string */
    public $type;

    /** @var string */
    public $name;

    /** @var int */
    public $up;

    /** @var int */
    public $ut;

    /** @var array<string, int> */
    public $cw;

    /** @var string */
    public $enc;

    /** @var array<int, mixed> */
    public $uv;

    /** @var bool */
    public $subsetted;

    public $originalsize;

    /** @var array<string, mixed> */
    public $desc;

    /** @var string */
    public $file;

    protected static $fontDefinitionList;

    public function __construct(string $font)
    {
        $this->font = $font;
    }

    public static function getFontDefinition(string $font): self
    {
        if (!isset(self::$fontDefinitionList)) {
            self::$fontDefinitionList = [];
        }
        if (!isset(self::$fontDefinitionList[$font])) {
            self::$fontDefinitionList[$font] = self::loadFontDefinition($font);
        }
        return self::$fontDefinitionList[$font];
    }

    public static function loadFontDefinition(string $font): self
    {
        $fontDesc = new self($font);
        if (file_exists(__DIR__ . '/font/' . $font . '.json')) {
            $jsonFontDesc = json_decode(file_get_contents(__DIR__ . '/font/' . $font . '.json', 'r'), true);
            $fontDesc->type = $jsonFontDesc['type'] ?? '';
            $fontDesc->name = $jsonFontDesc['name'] ?? '';
            $fontDesc->desc = $jsonFontDesc['desc'] ?? null;
            $fontDesc->file = $jsonFontDesc['file'] ?? null;
            $fontDesc->up = $jsonFontDesc['up'] ? (int)$jsonFontDesc['up'] : null;
            $fontDesc->ut = $jsonFontDesc['ut'] ? (int)$jsonFontDesc['ut'] : null;
            $fontDesc->originalsize = $jsonFontDesc['originalsize'] ?? null;
            $fontDesc->subsetted = $jsonFontDesc['subsetted'] ?? false;

            $fontDesc->cw = [];
            if (is_array($jsonFontDesc['cw']) && !empty($jsonFontDesc['cw'])) {
                foreach ($jsonFontDesc['cw'] as $index => $cw) {
                    $fontDesc->cw[chr($index)] = $cw;
                }
            }
            $fontDesc->enc = $jsonFontDesc['enc'] ? strtolower($jsonFontDesc['enc']) : '';
            $fontDesc->uv = [];
            if (is_array($jsonFontDesc['uv']) && !empty($jsonFontDesc['uv'])) {
                $fontDesc->uv = $jsonFontDesc['uv'];
            }
        } else {
            echo 'file not found "' . __DIR__ . '/font/' . $font . '"';
        }
        return $fontDesc;
    }

    public function asArray(): array
    {
        $response = [
            'font' => $this->font . '.php',
            'name' => $this->name,
            'subsetted' => $this->subsetted,
            'type' => $this->type,
            'up' => $this->up,
            'ut' => $this->ut,
            'cw' => $this->cw,
            'uv' => $this->uv
        ];
        if (!empty($this->enc)) {
            $response['enc'] = $this->enc;
        }
        if (isset($this->originalsize)) {
            $response['originalsize'] = $this->originalsize;
        }
        if (isset($this->desc)) {
            $response['desc'] = $this->desc;
        }
        if (isset($this->file)) {
            $response['file'] = $this->file;
        }
        return $response;
    }
}
