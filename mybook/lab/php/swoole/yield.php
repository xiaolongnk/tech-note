<?php

function xxrange($start , $end , $step = 1)
{
    for($i = $start ; $i <= $end ; $i+=$step){
        yield $i;
    }
}

foreach(xxrange(1 ,10) as $num){
    echo $num."\n";
}


?>
