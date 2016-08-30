<?php    
$mb = "I am 欧小龙";
$ans = mb_substr($mb , 0, 8 ,'utf8');
var_dump($ans);

function reverse($str)
{
	$ll = mb_strlen($str,'utf8');
	$ans = "";
	for($i = $ll; $i > 0 ; $i--){
		$ans.= mb_substr($str, $i-1 , 1 ,'utf8');
	}
	return $ans;
}
echo reverse($mb);

