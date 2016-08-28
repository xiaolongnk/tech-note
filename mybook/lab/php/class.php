<?php
class Base
{
    protected $a = "hello".PHP_EOL;
    protected function show()
    {
        print $this->a;
    }
}

class S extends Base{
    
    public function shows()
    {
        $this->show();
        print "here is shows".$this->a;
    }
}

$ac = new S();
$ac->shows();
?>
