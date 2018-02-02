<?php

/***
 * some data examples are as follows.
 西安 139 1.457142857
 南京 256 0.4555
 武汉 283 9
 深圳 155 8.8
 石家庄 283 8.75
 天津 155 8.67
 武汉 155 8.67
 **/

$fh = file_get_contents('s1.txt');
$lines = explode("\n", $fh);

// here is you sql base , table view.
$sql_base = "insert into  goods_city_price ( `city` ,`goods_id`, `price`) values ";
// your value should relative to your table view.
$sql_format = "('%s', '%s', '%s')";
$val = [];
foreach($lines as $f) {
    // 将多个空格变成一个空格
    $ss = preg_replace("/\s+/", " ", $f);
    if (empty($ss)) continue;
    $data = explode(" ", $ss);
    $city = $data[0];
    $goods_id = $data[1];
    $price = round($data[2],2) * 100;
    $val[] = sprintf($sql_format, $city, $goods_id, $price);
}

// generate a whole sql.
$val_str = implode(",", $val);
echo $sql_base.$val_str."\n";


?>
