<?php
namespace CoreTests;


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

    /** @var string|null */
    public $specificCreationDate;

    protected function _putinfo()
    {
        if (!empty($this->specificCreationDate)) {
            $this->metadata['Producer'] = 'FPDF ' . FPDF_VERSION;
            $this->metadata['CreationDate'] = 'D:' . $this->specificCreationDate;
            foreach ($this->metadata as $key => $value)
                $this->_put('/' . $key . ' ' . $this->_textstring($value));
        } else {
            parent::_putinfo();
        }
    }
}