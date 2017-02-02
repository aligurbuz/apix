<?php
/*
 * This file is client and http request of the queue service.
 *
 * client and rabbitMQ queue
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use src\services\httprequest as request;


/**
 * Represents a queue class.
 *
 * main call
 * return type string
 */

class rabbitMQ {

    public $request;
    private $connection;
    private $channel;

    /**
     * queue construct class.
     *
     */
    public function __construct(request $request){

        //request component
        $this->request=$request;
        //rabbitMQ connections
        $projectConfig="\\src\\app\\".app."\\".version."\\config\\rabbitMQ";
        $rabbitMQ=$projectConfig::rmqSettings();
        $this->connection = new AMQPStreamConnection($rabbitMQ['rabbitMQ']['host'], $rabbitMQ['rabbitMQ']['port'], $rabbitMQ['rabbitMQ']['user'], $rabbitMQ['rabbitMQ']['password']);
        $this->channel = $this->connection->channel();
    }

    public function test(){
        return 'hello world';
    }

}
