<?php

class Producer {

    /**
     * Kafka client conf
     * @var \RdKafka\Conf
     */
    protected $_conf;

    /**
     * kafka producer
     * @var \RdKafka\Producer
     */
    protected $_producer;

    /**
     * topic
     * @var \RdKafka\Topic
     */
    protected $_topic;

    /**
     * init
     * @param string $brokers
     * @param string $topic
     * @throws \Exception
     * @return \Kafka\Producer|NULL
     */
    public function __construct($brokers, $topic) {
        if(extension_loaded('rdkafka') === false) {
            throw new \Exception("rdkafka extension not installed, pecl install rdkafka", 8000);
        }

        $conf = new \RdKafka\Conf();
        $conf->set('group.id', 'api_kafka_client');
        $conf->set('client.id', 'newsrepublic');
        $conf->set('socket.timeout.ms', 1000);
        $conf->set('socket.max.fails', 3);
        $conf->set('topic.metadata.refresh.interval.ms', 1000);
        $conf->set('topic.metadata.refresh.fast.cnt', 3);
        $conf->set('topic.metadata.refresh.fast.interval.ms', 100);
        $conf->set('log_level', LOG_DEBUG);
        $conf->set('compression.codec', 'snappy');
        $conf->set('log.thread.name', true);
        $conf->set('reconnect.backoff.jitter.ms', 100);
        $conf->set('session.timeout.ms', 1000);

        $this->_producer = new \RdKafka\Producer($conf);
        $this->_producer->addBrokers($brokers);

        $topicConf   = new \RdKafka\TopicConf();
        $topicConf->set('request.required.acks', 1);
        $topicConf->set('request.timeout.ms', 1000);// 1 seconds
        $topicConf->set('message.timeout.ms', 300 * 1000);// 5 minutes
        //use file to store offset, default method broker
        //$topicConf->set('offset.store.method', 'file');
        //$topicConf->set('offset.store.path', '/tmp/kafka_offset.data');
        $topicConf->set('compression.codec', 'snappy'); //producer only

        try {
            $this->_topic = $this->_producer->newTopic($topic, $topicConf);
            $this->_producer->getMetadata(false, $this->_topic, 60e3);
            return $this;
        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg  = $e->getMessage();
            return null;
        }
    }

    public function Produce($message) {
        return $this->_topic->produce(RD_KAFKA_PARTITION_UA, 0, $message);
    }

    public function consumer()
    {
        $conf = new \RdKafka\Conf();
        $conf->set('group.id', 'api_kafka_client');
        $conf->set('client.id', 'newsrepublic');
        $conf->set('socket.timeout.ms', 1000);
        $conf->set('socket.max.fails', 3);
        $conf->set('topic.metadata.refresh.interval.ms', 1000);
        $conf->set('topic.metadata.refresh.fast.cnt', 3);
        $conf->set('topic.metadata.refresh.fast.interval.ms', 100);
        $conf->set('log_level', LOG_DEBUG);
        $conf->set('compression.codec', 'snappy');
        $conf->set('log.thread.name', true);
        $conf->set('reconnect.backoff.jitter.ms', 100);
        $conf->set('session.timeout.ms', 1000);

        $rk = new \RdKafka\Consumer($conf);
        $rk->addBrokers('127.0.0.1:9092');
        $topicConf = new RdKafka\TopicConf();
        // Set the offset store method to 'file'
        $topicConf->set('offset.store.method', 'broker');
        //$topicConf->set('offset.store.method', 'file');
        //$topicConf->set('offset.store.path', '/tmp/kafka_offset.data');
        $topicConf->set('auto.commit.interval.ms', 50);
        $topicConf->set('auto.offset.reset', 'smallest');
        $topic = $rk->newTopic("test", $topicConf);
        // Start consuming partition 0
        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
        echo "consume started\n";
        while (true) {
            $message = $topic->consume(0, 1 * 1);
            if(empty($message)) {
                sleep(2);
                echo "no message\n";
                continue;
            }
            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $payload = $message->payload;
                    $offset  = $message->offset;
                    var_dump($message);
                    echo $payload . "\t" . $offset . PHP_EOL;
                break;
                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;
                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    echo "Timed out\n";
                    break;
                default:
                    //throw new \Exception($message->errstr(), $message->err);
                break;
            }
            sleep(2);
        }
    }
}


class KafkaTest
{
	public function test()
	{
		$topic    = 'test';
		$brokers  = '127.0.0.1:9092';
		$producer = new Producer($brokers, $topic);
		for ($i = 0; $i< 1000000; $i++ ) {
            $result = $producer->Produce('msg ' . $i);
			usleep(1000000);
		}
    }

    public function consumer()
    {
        $topic = 'test';
        $brokers= '127.0.0.1:9092';
        $pro = new Producer($brokers , $topic);
        $pro->consumer();
    }
}
$n = new KafkaTest();
$n->consumer();
?>
