<?php
/**
 * redis config controller
 * it is mainly redis connection for service
 * service redis provider
 */

namespace src\app\testApp\v1\config;

class redis
{

    /**
     * project app.
     *
     * redis access for every service.
     *
     * @param string
     * @return response redis runner
     */
    public static function redisConnection()
    {

        //redis settings
        $redis['connection']['host']=env('redis_host', '127.0.0.1');
        $redis['connection']['port']=env('redis_port', '6379');
        $redis['connection']['scheme']=env('redis_scheme', 'tcp');

        //select database names
        //$redis['databases']['redisDb::log']=env('redisDb::log',1);

        //return redis
        return $redis;
    }
}
