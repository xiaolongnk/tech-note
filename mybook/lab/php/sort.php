<?php
$t = [-3,100,20,2,90,-90,6];

function swap_test()
{
    $a = [123,33];
    for($i = 0; $i < 100; $i++){
        swap($a[0], $a[1]);
        print_r($a) ;
    }
}


trait QuickSort{

    private static function swap2(&$a , &$b)
    {
        $c = $a ;
        $a = $b;
        $b = $c;
    }

    private static function swap1(&$a , &$b)
    {
        $a = $a ^ $b;
        $b = $a ^ $b;
        $a = $a ^ $b;
    }
    private static function swap(&$a , &$b)
    {
        self::swap2($a , $b);
    }

    // 将一个元素按照一个值分成2部分，然后返回这个元素的下标
    private static function msplit(&$t , $l , $r , $sort_flag)
    {
        if($l >= $r) return -1;
        $len = $r - $l;
        $key = $t[$r];
        $cnt = $l;
        for($i = $l; $i < $r ; $i++){
            if($sort_flag =='+'){
                if($t[$i] < $key){
                    self::swap($t[$i] , $t[$cnt++]);
                }
            }else if($sort_flag =='-'){
                if($t[$i] > $key){
                    self::swap($t[$i] , $t[$cnt++]);
                }
            }
        }
        self::swap($t[$r] , $t[$cnt]);
        return $cnt;
    }

    public static function quick_sort(&$t , $l , $r , $sort_flag)
    {
        $idx = self::msplit($t , $l , $r , $sort_flag);
        //print("l == ".$l."  r==".$r."  idx==".$idx."\n");
        if($idx == -1) return;
        self::quick_sort($t ,$l , $idx - 1 , $sort_flag);
        self::quick_sort($t , $idx + 1 , $r , $sort_flag);
    }
}

trait MergeSort
{
    public static function merge_sort(&$t , $l , $r , $sort_flag)
    {
        if($l >= $r) return ;
        $mid = ($l  + $r)/2;
        merge_sort($t , $l , $mid, $sort_flag);
        merge_sort($t , $mid + 1 , $r , $sort_flag);
        merge($t , $l , $mid , $r , $sort_flag);
    }

    public static function merge(&$t , $l , $mid , $r , $sort_flag)
    {

    }
}
//问题，将swap中的swap函数换成swap1可以正常排序，换成swap2就排错了，更不知道为什么，交换算法应该是没有错误的，单独测试也没有错误，不知道有什么猫腻。
print_r($t);
QuickSort::quick_sort($t,0,count($t) - 1, '+');
print_r($t);


?>
