<?php
$path="/Users/ouxiaolong/code/note/mybook/";


function print_sub_path($path , $indent)
{
    $fh = dir($path);
    while(false !== ($entry = $fh->read())){
        if($entry == '.' || $entry == '..') continue;
        for($i = 0; $i<$indent; $i++) print " ";
        $sub_path = $path."$entry";
        if(is_dir($sub_path)){
            echo "$entry\n";
            print_sub_path($sub_path."/" , $indent + 5);
        }else if(is_file($sub_path)){
            print $entry."\n";
            process_file();
            //echo "$entry is a file\n";
        }
    }
}
print_sub_path($path , 0);

function process_file()
{

}
?>
