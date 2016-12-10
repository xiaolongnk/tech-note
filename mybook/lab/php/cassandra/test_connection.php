<?php
class CassandraFactory
{
    static private $instance = null;

    private function __construct()
    {
        echo "ini here".PHP_EOL;
    }

    public static function getInstance()
    {
        if(empty($this->instance)){
            $this->instance = new self();
        }
        return $this->instance;
    }

    public function query()
    {

    }

    public function insert()
    {

    }

    public function update()
    {
        $cluster   = Cassandra::cluster()->build();
        $keyspace  = 'test';
        $session   = $cluster->connect($keyspace);
        $statement = new Cassandra\SimpleStatement( 'SELECT * from test');
        $future    = $session->executeAsync($statement);
        $result    = $future->get();
        foreach ($result as $row) {
            var_dump($row);
        }

    }
}
$p = CassandraFactory::getInstance();

