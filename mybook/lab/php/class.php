<?php
class Base
{
    protected $_display = 1;
    protected function show()
    {
        print $this->_display;
    }

    public function setDisplay($v)
    {
        $this->_display = $v;
    }
}

class S extends Base{

    public function shows()
    {
        echo $this->_display.PHP_EOL;
    }
}

$ac = new S();
$ac->setDisplay(20);

$method = "shows";
$ac->$method();
?>
