<?php
/**
 * rabbitMQ config controller
 * it is mainly rabbitMQ connection for service
 * service rabbitMQ provider
 */

namespace src\app\__projectName__\v1\config;

class rabbitMQ
{

    /**
     * project app.
     *
     * rabbitMQ access for every service.
     *
     * @param string
     * @return response Rabbitmq runner
     */
    public static function rmqSettings()
    {


        //RMQ settings
        $rmq['rabbitMQ']['host']=env('rabbitMQ_host', '192.168.33.10');
        $rmq['rabbitMQ']['port']=env('rabbitMQ_port', '15672');
        $rmq['rabbitMQ']['user']=env('rabbitMQ_user', 'guest');
        $rmq['rabbitMQ']['password']=env('rabbitMQ_password', 'guest');

        //return db
        return $rmq;
    }
}
