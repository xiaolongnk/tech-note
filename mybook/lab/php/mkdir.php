<?php
/**
 * 存储图片的时候经常会用到这个函数，目录创建
 * 先需要创建上级目录，再创建下级目录
 */

$t = date("Y/m/d");

function mkdirs($dir){
    if(!is_dir($dir)){
        if(!mkdirs(dirname($dir))){
            return false;
        }

        if(!mkdir($dir , 0777)){
            return false;
        }
    }
    return true;
}


$ret = mkdirs($t);
var_dump($ret);

