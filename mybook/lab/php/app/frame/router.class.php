<?php
/**
 * This is router class
 */

namespace App\Frame;

class Router
{

    private function __construct()
    {
        echo "in Router\n";
    }

    public static function getInstance()
    {
        static $siglenton = null;
        is_null($siglenton) && $siglenton = new self();
        return $siglenton;
    }

}
?>
