<?php
/**
 * database config controller
 * it is mainly database connection for service
 * service database provider
 */

namespace src\app\testApp\v1\config;

class database
{

    /**
     * project app.
     *
     * static call access for every service.
     *
     * @param string
     * @return response container runner
     */
    public static function dbSettings()
    {

        //default connection
        $connection='mysql';

        //local settings
        $db['mysql']['driver']=env('driver', 'mysql');
        $db['mysql']['host']=env('host', 'localhost');
        $db['mysql']['database']=env('database', 'database');
        $db['mysql']['user']=env('user', 'user');
        $db['mysql']['password']=env('password', 'password');

        //return db
        return $db[$connection];
    }
}
