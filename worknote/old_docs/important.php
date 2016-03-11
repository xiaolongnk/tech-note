<?php

function get_category_list($output , $parent_id)
{
    $sql = "select cid , name , is_parent from category where parent_cid = $parent_id and status = 1";
    $ret = parent::getConnection()->query($sql);
    if(empty($ret)) {
        $_REQUEST['sss'][] = $output;
        return "";
    }
    foreach ($ret as $row)
    {
        $sub_str = $output."   ".$row->name."   ".$row->cid;
        self::get_category_list($sub_str , $row->cid);
    }
}


$file_handle = fopen("xxx.xx", "r");
while (!feof($file_handle)) {

    $line = fgets($file_handle);
    $data = explode(",",$line);
    $cnt = count($data);
    $table_name = "export_goods".trim(' '.$data[0]);
    $export_goods_sql = "create table $table_name as select goods_id, goods_name, goods_desc, root_category_id, root_category_name ,category_id, category_name, subcate_id, subcate_name from higo.t_pandora_goods  where  goods_status = 1 and ";
    $where_cond = "";
    if($cnt ==0  ) continue;
    if(empty($data[0])) continue;
    if($cnt > 0) {
        $where_cond = "root_category_id =".$data[0];
    }
    $sql = $export_goods_sql.$where_cond;
    echo $sql."\n\n";
}
fclose($file_handle);

?>
