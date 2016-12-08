<?php

class Consumer
{
    public function hello($callback)
    {
        var_dump($callback);
        $cnt = 0;
        while(true){
            ++$cnt;
            sleep(1);
            call_user_func($callback , $cnt , $cnt+100);
        }
    }

    public static function tt($para)
    {
        echo "now in tt $para ".PHP_EOL;
    }

    public function test($callback , $para)
    {
        var_dump($callback);
        call_user_func($callback , $para);
    }
}


$p = new Consumer();
$p->test(['Consumer' , 'tt'] , 123);


function helloworld($cnt , $cnt1)
{
    echo "->  $cnt and $cnt1".PHP_EOL;
}
?>
