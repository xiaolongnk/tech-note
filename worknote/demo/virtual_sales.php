<?php

$test_arr = [];
$goods = new \stdClass();
$goods->goods_id = 123123;
$goods->goods_repertory = 10;
$goods->start = 1460432066;
$goods->end = 1460450739;
$goods->sales = 0;
$test_arr[] = $goods;


function init($test_arr)
{
    $virtual_obj = new AddVirtual();
    foreach($test_arr as $row)
    {
        $virtual_obj->add_virtual($row);
        $virtual_obj->cacu_virtual($row);
    }
}



class AddVirtual 
{
    /**
     * 添加虚拟库存变化的相关属性。
     * 虚拟库存的最终数值。
     * 虚拟库存的变化间隔。
     * 虚拟库存的变化周期。
     * 用户购买的进度增长。
     */
    function add_virtual(&$goods_obj)
    {
        $time_abs = intval(($goods_obj->end - $goods_obj->start) * 0.8); 
        $goods_obj->final_virtual = rand(70, 90)/100;
        $goods_obj->update_time_interval = intval($time_abs / $goods_obj->goods_repertory);
        $goods_obj->update_data_interval = $goods_obj->final_virtual / $goods_obj->goods_repertory;
        $goods_obj->last_update_time = $goods_obj->start;
        $goods_obj->last_update_diviation = 0;
        $goods_obj->percent = 0;
    }

    /**
     * 计算虚拟库存，和时间相关。
     * 和商品的实际销售相关。
     */

    function cacu_virtual(&$goods_obj)
    {
        $now = time();
        $time_abs = $now - $goods_obj->last_update_time;
        $times = $time_abs / $goods_obj->update_time_interval;
        if($times >= 1){
            $goods_obj->last_update_time = $now;
            if($goods_obj->last_update_diviation == 0) {
                $goods_obj->last_update_diviation =  $goods_obj->update_data_interval * rand(30,100)/100;
                $goods_obj->last_update_diviation = (rand(1,2) == 1)?$goods_obj->last_update_diviation : -1*$goods_obj->last_update_diviation;
                $goods_obj->percent += $goods_obj->last_update_diviation + $goods_obj->update_data_interval * $times;
            }else {
                $goods_obj->percent += $goods_obj->last_update_diviation*-1 + $goods_obj->update_data_interval * $times;
                $goods_obj->last_update_diviation = 0;
            }
        }
        // add sales_part;
        $vs = (1 - $goods_obj->final_virtual) * ($goods_obj->sales/$goods_obj->goods_repertory);       
        $goods_obj->percent += $vs;

        // 如果真是 百分比 大于虚拟百分比，那么就用真实百分比.
        $real_percent = floatval($goods_obj->sales) / ($goods_obj->sales + $goods_obj->goods_repertory);
        if($real_percent > $goods_obj->percent) $goods_obj->percent = $real_percent;
        // 需要区分很快销售完的商品。
    }
}

function test($test_arr)
{
    init($test_arr);
}
test($test_arr);
var_dump($test_arr);
?>
