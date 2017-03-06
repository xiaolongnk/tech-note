<?php

/***
 * max length of the ads position can display is 34;
 * min_space between source and taboola is 8 blank space;
 * if source is longger , then Powerd By can be skipped;
 * if source is still logger , then Powered By Taboola can be skipped;
 ***/
function format_string($origin_str)
{
    $cst = "Powerd By Taboola";     // len is 17 , powerd by can be skipped whose length is 10.
    $taboola_cst = "Taboola";       // len is 8
    $min_space = "        ";        // len is 8
    $final_str = "";
    $j = 9 - strlen($origin_str) ;  // 9 = 34 - 17 - 8
    if($j > 0) {
        $blank_space = "";
        for($i = 0 ; $i < $j ; ++$i) $blank_space.=" ";
        $final_str = $origin_str.$min_space.$blank_space.$cst;
    } else if ($j > -11 ){
        $blank_space = "";
        for($i = 0 ; $i < 10 + $j ; $i++) $blank_space.=" ";
        $final_str = $origin_str.$min_space.$blank_space.$taboola_cst;
    } else {
        return $origin_str;
    }
    return $final_str;
}



exit(0);
// below are test code.
$list = [];
for($i = 0 ; $i < 40; ++$i) {
    $str = "";
    for($j = 0 ; $j < $i ; ++$j) {
        $str .="x";
    }
    $list[] = $str;
}

for($i = 0 ; $i < count($list) ; ++$i) {
    echo format_string($list[$i])."\n";
}



