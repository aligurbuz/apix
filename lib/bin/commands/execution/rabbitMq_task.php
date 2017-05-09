<?php
/*
 * This file is rabbit queue command .
 * RabbitMQ is a message broker: it accepts and forwards messages
 * You can think about it as a post office: when you put the mail that you want posting in a post box,
 * you can be sure that Mr. Postman will eventually deliver the mail to your recipient
 * In this analogy, RabbitMQ is a post box, a post office and a postman
 *
 * publisher class for rabbitMQ
 */

namespace src\app\__projectName__\__version__\optional\jobs\rabbitMq\__dir__;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Src\Store\Services\RabbitMQ as rabbit;
use Src\Store\Services\Httprequest as Request;

/**
 * A queue is the name for a post box which lives inside RabbitMQ
 * Although messages flow through RabbitMQ and your applications,
 * @class publisher
 */
class task {


    //get channel
    public $scheduleTime='* * * *';


    /**
     * Console rabbitMQ execute method.
     *
     * @param directly handle method
     * execute loader as construct method
     * @return string
     * @return string
     */
    public function execute(){

        //make task
    }


}