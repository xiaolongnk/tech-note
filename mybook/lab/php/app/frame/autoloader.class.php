<?php
namespace App;

class AutoLoader
{
    private $root_path = null;

    private function __construct($root_path)
    {
        $this->root_path = $root_path;
        spl_autoload_register([$this,'autoload']);
    }
    
    private function autoload($class)
    {
        var_dump($class);
        $arr =explode('\\',$class);
        array_shift($arr); // shift  project name.
        $relative_path = implode("/",$arr);
        $class_real_path = $this->root_path.'/'.strtolower($relative_path).'.class.php';
        require $class_real_path;
    }

    public static function get($root_path){
        static $siglenton = null;
        is_null($siglenton) && 
            $siglenton = new self($root_path);
        return $siglenton;
    }
}

?>
