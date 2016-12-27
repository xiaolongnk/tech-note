<?php
define('__NEWLINE' , "\n");
define('__TAB' , "\t");
class CassandraFactory
{
    private $session = null;
    private $keyspace = '';

    private function __construct($keyspace)
    {
        $host = "127.0.0.1";
        $port = 6666;
        $cluster= Cassandra::cluster()->withContactPoints($host)->withPort($port)->build();
        $this->session = $cluster->connect();
        if(!empty($keyspace)) {
            $this->keyspace = $keyspace;
            $usekeyspace = "USE $keyspace";
            $this->session->execute(
                new Cassandra\SimpleStatement($usekeyspace)
            );
        }
    }

	public function getSession()
    {
        return $this->session;
    }

    public static function getInstance($keyspace = '')
    {
        static $instance = null;
        if(empty($instance)){
            $instance = new self($keyspace);
        }
        return $instance;
    }

    public static function check()
    {
        // check if the extension is on.
        echo "cassandra check:".__NEWLINE;
        if (!extension_loaded( 'cassandra' )){
            echo "extension not found: cassandra".__NEWLINE;
            $check_result = "cassandra check failed".__NEWLINE;
            goto exitline;
        }
        $cassanfactory = new self('');
        $session = $cassanfactory->getSession();
        $schema = $session->schema();
        foreach($schema->keyspaces() as $sc){
            echo __TAB.__TAB."{$sc->name()}".__NEWLINE;
        }
        $check_result = "cassandra check ok".__NEWLINE;
        exitline:
        echo $check_result;
    }


    public function changeKeySpace($keyspace)
    {
        $this->keyspace = $keyspace;
        $usekeyspace = "use $keyspace";
        $ret = $this->execute($usekeyspace);
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
    }
}

function test_connection_code()
{
    $p = CassandraFactory::getInstance();
    $query_cql = "SELECT keyspace_name, columnfamily_name FROM system.schema_columnfamilies";
    echo "query cassandra info\n";
    $ret = $p->query($query_cql , []);
    if($ret){
        foreach($ret as $row){
            echo "\tkeyspace [{$row['keyspace_name']}]  column [{$row['columnfamily_name']}] \n";
        }
    }else {
        echo "query got nothing.\n";
    }
}
/**
 * create keyspace and table.
 */
function initialize_keyspace()
{
    $p = CassandraFactory::getInstance();
    $new_key_space = 'test_01';
    $create_keyspace_cql = "CREATE KEYSPACE $new_key_space
        WITH REPLICATION = { 'class' : 'SimpleStrategy', 'replication_factor' : 1 }";
    $ret = $p->createKeySpace($create_keyspace_cql);
    $ret = serialize($ret);
    echo "create keyspace finished with ret [ $ret ]\n";
    $p->changeKeySpace($new_key_space);
    $create_table_cql = "create table media_source_table (aid varchar primary key, 
        media_source varchar , ext varchar)";
$ret = $p->createTable($create_table_cql);
$ret = serialize($ret);
    echo "create table finished with ret [ $ret] \n";
}

function test_op_code()
{
    $new_key_space = 'test_01';
    $p = CassandraFactory::getInstance($new_key_space);
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
    
    $test_query_cql = "select media_source from media_source_table where aid = ?";
    $test_query_cql_bind_data = ['111111'];
    $ret_q = $p->query($test_query_cql , $test_query_cql_bind_data);
}

//initialize_keyspace();
CassandraFactory::check();
