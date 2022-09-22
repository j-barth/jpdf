<?php
namespace Tests;


class TestableFpdf extends \Jbarth\Fpdf
{
    public function getParam($name)
    {
        return $this->$name;
    }

    public function setParam($name, $value)
    {
        $this->$name = $value;
    }
}