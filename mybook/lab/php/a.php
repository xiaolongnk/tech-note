<?php

class WriteFile
{

    public static function writeToFile($file_name , $data_arr )
    {
        foreach($data_arr as $k => $v) {
            $str = "$k,$v\n";
            $ret = file_put_contents($file_name, $str, FILE_APPEND | LOCK_EX);
        }
    }
}
$data_arr = [
    "key1" => "value1",
    "key2" => "value2",
    "key3" => "value3",
    "key4" => "value4",
    "key5" => "value5",
    "key6" => "value6",
    "key7" => "value7",
    "key8" => "value8",
    "key9" => "value9",
    "key10" => "value10",
    "key11" => "value11",
    "key12" => "value12",
    "key13" => "value13"
];
$cnt = 1;
//WriteFile::writeToFile("/home/faith/hello.json" , $data_arr);
//
//
$b = "hello@@@@@world";
$c =explode("@@@@@" , $b);
var_dump($c);
