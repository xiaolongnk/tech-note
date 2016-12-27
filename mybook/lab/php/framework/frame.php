<?php
/*****
 * use this Model base class , your module will not need to catch exception.
 * and deal with output, focus on your bussiness logic.
 * ***/


class ErrorCode
{
    const CLASS_NOT_EXISTS        = 4001;
    const CLASS_METHOD_NOT_EXISTS = 4002;
}

class Model
{
    protected $data;
    private $called_class;
    private $sapi_name;

    final public function __construct()
    {
        $this->called_class = get_called_class();
        $this->sapi_name = php_sapi_name();
    }

    final public function control($method)
    {
        if(method_exists($this , $method)){
            $this->$method();
            $this->output();
        }else {
            throw new \Exception(
                "$this->called_class method $method not found",
                ErrorCode::CLASS_METHOD_NOT_EXISTS);
        }
    }

    final public function output()
    {
        if($this->sapi_name == 'cli') {
            var_dump($this->data);
        }else {
            header("Content-Type : application/json;charset=UTF-8;");
            echo json_encode($this->data);
        }
    }
}

class Server extends Model
{

    public function getInfo()
    {
        $data = [
            'pg' => 1,
            'cg' => 2,
            'dg' => 3
        ];
        $this->data = $data;
    }
}

class ControllerPM
{
    private function __construct()
    {

    }

    public static function getInstance()
    {
        static $instance = null;
        if(is_null($instance)){
            $instance = new self();
        }
        return $instance;
    }

    public function callMethod($call_string)
    {
        list($class , $method) = explode('/' , $call_string);
        $classInstance = new $class();
        try {
            $classInstance->control($method);
        } catch(\Exception $e){
            echo "Exception code [ {$e->getCode() }] msg [ {$e->getMessage()} ]\n";
        }
    }
}


/***
 * this is test function.
 * test logics are here.
 * 1. test for call a model method. one controller can contain multiple method.
 ***/

function test()
{
    $p = ControllerPM::getInstance()->callMethod('Server/getInfo');
}

test();
?>
