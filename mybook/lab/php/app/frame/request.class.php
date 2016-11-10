<?php

namespace App\Frame;

/**
 * this is HttpRequest class
 * parse request from http or cli
 */

class Request
{

    private function __construct()
    {

    }

    private function getInstance()
    {
        static $siglenton = null;
        is_null($siglenton) && $siglenton = new self();
        return $siglenton;
    }
}
