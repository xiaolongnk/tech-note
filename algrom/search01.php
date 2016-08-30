<?php
/**
 * 计算f(n),将所有的可能组合打印出来，分解的元素只能是1或者2，将所有的组合打印出来。
 */
function solutions($n , $curSteps , $path , &$total)
{
    if($n < $curSteps) return;
    if($n == $curSteps){
//        print($path."\n");
        $total++;
        return;
    }
    solutions($n , $curSteps + 1,$path==''?$path."1":$path.",1" , $total);
    solutions($n , $curSteps + 2,$path==''?$path."2":$path.",2" , $total);
}

$total = 0;
$currentStep = 0;
$path = '';
solutions(100,$currentStep,$path,$total);
print "total solution is:$total\n";




?>
