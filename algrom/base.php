<?php


/**
 * 包括一些基本的算法。
 * 二叉树的非递归遍历。递归和非递归遍历。
 */
function base_test()
{
    $a = ['k1'=>1,'k2'=>2,'k3'=>3];

    function sub_move(&$v)
    {
        $len = count($v) - 1;
        $temp = $v[$len - 1];
        for($i = $len - 1; $i > 0; $i--){
            $v[$i] = $v[$i-1];
        }
        $v[0] = $temp;
    }

    $keys = array_keys($a);
    $vals = array_values($a);

    sub_move($vals);
    //print_r($a);
    //print_r(array_combine($keys , $vals));

    $a =[1=>1,1=>1,3=>2,4,4,6];
    //var_dump(array_unique($a));

    //
    $b = [1,2,3,4];
    array_walk($b , function(&$v){ 
        $v =$v * $v;
    });
    var_dump($b);
}

function base_test1()
{
    class Node {

        function __construct($val = 0)
        {
            $this->v = $val;
        }
        public $l = NULL;
        public $r = NULL;
        public $v = 0;
    }

    $root = new Node(10);

    function buildTree(&$root)
    {
        $root->l = new Node(5);
        $root->r = new Node(19);
        $root->l->l = new Node(8);
        $root->l->r = new Node(3);
        $root->r->r = new Node(13);
        $root->r->l = new Node(29);
    }


    function printTree($root , $depth)
    {
        if($root){
            printTree($root->l , $depth + 2);
            for($i = 0 ; $i < $depth ; $i++) print " ";
            print $root->v."\n";
            printTree($root->r , $depth + 2);
        }
    }

    trait RecursiveOutput
    {
        public static function preOrder($root , $n)
        {
            if($root){
                echo "{$root->v} ";
                self::preOrder($root->l , $n+1);
                self::preOrder($root->r , $n+1);
                if($n == 0) echo "\n";
            }
        }
        //先左孩子，后中序，后右孩子
        public static function inOrder($root , $n)
        {
            if($root){
                self::inOrder($root->l , $n+1);
                echo "{$root->v} ";
                self::inOrder($root->r , $n+1);
                if($n == 0) echo "\n";
            }

        }
        //先左孩子，后右孩子，再中间的节点
        public static function postOrder($root , $n)
        {
            if($root){
                self::postOrder($root->l , $n+1);
                self::postOrder($root->r , $n+1);
                echo "{$root->v} ";
                if($n == 0) echo "\n";
            }
        }
    }

    trait NonRecursiveOutput
    {
        public static function preOrder($root)
        {
            $lst = [];
            while($root || count($lst)){
                while($root){
                    print "{$root->v} ";
                    array_push($lst, $root);
                    $root = $root->l;
                }
                if(count($lst) ){
                    $root = array_pop($lst);
                    $root = $root->r;
                }
            }
            echo "\n";
        }

        public static function inOrder($root)
        {
            $lst = [];
            while($root || count($lst)){
                while($root){
                    array_push($lst , $root);
                    $root = $root->l;
                }
                if($root == null){
                    $root = array_pop($lst);
                    print "{$root->v} ";
                    $root = $root->r;
                }
            }
            print "\n";
        }

        public static function postOrder($root)
        {
            $lst = [];
            array_push($lst , $root);
            $pre = null;
            while(!empty($lst)){
                $root = $lst[count($lst)-1];
                if(($root->l == null && $root->r == null)
                    || ($pre!=null && (
                    $pre == $root->l || $pre == $root->r)))
                {
                    echo "{$root->v} ";
                    $pre = $root;
                    array_pop($lst);
                }else {
                    if($root->r !=null) array_push($lst,$root->r);
                    if($root->l !=null) array_push($lst,$root->l);
                }
            }
            echo "\n";
        }
    }

    buildTree($root);
    printTree($root , 0);
//    RecursiveOutput::preOrder ($root , 0);
//    RecursiveOutput::inOrder  ($root , 0);
    RecursiveOutput::postOrder($root , 0);
//  NonRecursiveOutput::preOrder($root);
//  NonRecursiveOutput::inOrder($root);
    NonRecursiveOutput::postOrder($root);
}


base_test1();
?>
