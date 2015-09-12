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
?>
