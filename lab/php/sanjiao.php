<?php
trait AlgorithmKit{

    public $appName = 'AlgorithmKit';
    public function yangHuiSanJiao($N)
    {
        $mp = [];
        for($i = 0; $i<$N; $i++){
            $mp[] = [];
            for ($j=0;$j < $N; $j++){
                $mp[i][j] = 0;   
            }
        }
        $mp[0][0]=1;
        print $mp[0][0]."\n";
        for($i = 1; $i < $N; $i++){
            for($j = 0; $j < $i+1; $j++){
                $l = ($j == 0) ? 0 : $mp[$i-1][$j-1];
                $r = ($mp[$i-1][$j] == 0) ? 0 :$mp[$i-1][$j];
                $mp[$i][$j] = $l + $r;
                print $mp[$i][$j]." ";
            }
            print "\n";
        }

    }

    public function getCnm($n , $m)
    {
        if($n < $m) return 0;
        function getSubMul($a , $b = 1)
        {
            $ans = 1;
            for($i = $a ; $i >= $b ; $i--){
                try{
                    $ans *= $i;
                }catch(Exception $e){
                    var_dump($e);
                }
            }
            return $ans;
        }
        $a = getSubMul( $n , $n-$m+1 );
        $b = getSubMul( $m );
        return $a / $b;
    }

    public function test($a , $b = 1)
    {
        $ans = 1;
        try{
            for($i = $a ; $i >= $b ; $i--){
                $ans *= $i;
            }
        }catch(\Exception $e){
            die('xx');
            print "xxx";
            var_dump($e);
        }
        return $ans;

    }
    public function testArrayMerge()
    {
        
        $a = ['name'=>'xiaolong'];
        $b = ['age' => 21];
        $c = ['wife' => 'liangliang'];
        $dd = array_merge($a , $b);
        return $dd;
    }

	function addColumn($type, $name, array $parameters = array())
	{
		$attributes = array_merge(compact('type', 'name'), $parameters);
		$columns[] = $column = '2233';
		var_dump($column);
		var_dump($columns);
        var_dump($attributes);
		return $column;
	}



}

//AlgorithmKit::yangHuiSanJiao(10);
//print AlgorithmKit::getCnm(4,2);
//print AlgorithmKit::test(1000);
//$p = AlgorithmKit::testArrayMerge();
AlgorithmKit::addColumn('timestamp','created_at',['default'=>'0000-00-00 00:00:00']);

?>
