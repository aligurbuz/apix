<?php
/*
 * This file is client and http request of the queue service.
 *
 * client and rabbitMQ queue
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;
use lib\utils;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use src\store\services\httprequest as request;


/**
 * Represents a queue class.
 *
 * main call
 * return type string
 */

class rabbitMQ {

    private $connection;
    private $channel;

    /**
     * queue construct class.
     *
     */
    public function __construct($app=null){

        //rabbitMQ connections
        if($app!==null){
            $projectConfig="\\src\\app\\".$app."\\".utils::getAppVersion($app)."\\config\\rabbitMQ";
        }
        else{
            $projectConfig="\\src\\app\\".app."\\".version."\\config\\rabbitMQ";
        }

        $rabbitMQ=$projectConfig::rmqSettings();
        $this->connection=new AMQPStreamConnection($rabbitMQ['rabbitMQ']['host'], $rabbitMQ['rabbitMQ']['port'], $rabbitMQ['rabbitMQ']['user'], $rabbitMQ['rabbitMQ']['password']);

    }

    public function getConnection(){
        return $this->connection;
    }


}
