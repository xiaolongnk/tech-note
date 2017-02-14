<?php
class Test
{
    public static function geneRateBase($param_function)
    {
        $ar = [];
        for($i =  0 ; $i<100 ; $i ++)
        {
            $ar[] = $i;
        }
        $param_function($ar);
    }


}

?>
