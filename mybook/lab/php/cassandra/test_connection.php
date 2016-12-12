<?php
class CassandraFactory
{
    private $session = null;
    private $keyspace = '';

    private function __construct($keyspace)
    {
        $host = "127.0.0.1";
        $port = 9042;
        $cluster= Cassandra::cluster()->withContactPoints($host)->withPort($port)->build();
        $this->session = $cluster->connect();
        if(empty($keyspace)) {
            echo "keyspace should not empty!";
        }
        $this->keyspace = $keyspace;
        $usekeyspace = "USE $keyspace";
        $this->session->execute(
            new Cassandra\SimpleStatement($usekeyspace)
        );


    }

    public static function getInstance($keyspace)
    {
        static $instance = null;
        if(empty($instance)){
            $instance = new self($keyspace);
        }
        return $instance;
    }


    public function changeKeySpace($keyspace)
    {
        $this->keyspace = $keyspace;
        $usekeyspace = "use $keyspace";
        $ret = $this->session->execute($usekeyspace);
        return $ret;
    }

    private function execute($cql , $bind_data = [])
    {
        try {
            $ret_insert_cql = $this->session->execute(
                new Cassandra\SimpleStatement($cql),
                new Cassandra\ExecutionOptions(['arguments' => $bind_data])
            );
            return $ret_insert_cql;
        }catch(\Exception $e){
            echo "exception occured with mmsg [{$e->getMessage()}] code [ {$e->getCode()} ]\n";
            return -1;
        }
    }

    public function insert($cql  , $bind_data)
    {
        return $this->execute($cql , $bind_data);
    }

    public function query($cql , $bind_data)
    {
        return $this->execute($cql , $bind_data);
    }

    public function update($cql , $bind_data)
    {
        return $this->execute($cql , $bind_data);
    }

    public function createKeySpace($cql)
    {
        // here to create your keyspaces
        return $this->execute($cql);
    }

    public function createTable($cql)
    {
        // here to create your table.
        return $this->execute($cql );
    }

    public function __destruct()
    {
        $this->session->close();
        echo "destoryed\n";
    }
}

$keyspace = "test";
$p = CassandraFactory::getInstance($keyspace);

$create_keyspace_cql = "CREATE KEYSPACE test_01 
    WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }";

$ret = $p->createKeySpace($create_keyspace_cql);
echo "create keyspace finished with ret [ $ret ]\n";

$create_table_cql = "create table media_source_table (aid varchar primary key, 
    media_source varchar , ext varchar)";
$ret = $p->createTable($create_table_cql);

echo "create table finished with ret [ $ret] \n";

$test_insert_cql = "insert into media_source_table (aid , media_source , ext ) values (? , ? , ' ')" ;
$test_insert_cql_bind_data =[
    ['111114' , 'facebook'],
    ['111115' , 'google'],
    ['111116' , 'twitter'],
    ['111117' , 'facebook'],
    ['111118' , 'google']
];

foreach($test_insert_cql_bind_data as $v){
    $ret = $p->insert($test_insert_cql , $v);
    $ret = serialize($ret);
    echo "insert finished with ret [ {$ret} ]\n";
}


//$test_insert_cql_bind_data = ['111112' , 'google'];
//$test_insert_cql_bind_data = ['111113' , 'facebook'];
//$test_insert_cql_bind_data = ['111114' , 'twitter'];

//$test_update_cql = "";
//$test_update_cql_bind_data = [];


$test_query_cql = "select media_source from media_source_table where aid = ?";
$test_query_cql_bind_data = ['111111'];
$ret_q = $p->query($test_query_cql , $test_query_cql_bind_data);