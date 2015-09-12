<?php

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
