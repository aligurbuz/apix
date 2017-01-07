<?php
/**
 * database config controller
 * it is mainly database connection for service
 * service database provider
 */

namespace src\app\mobi\v1\config;


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
    public static function dbSettings(){

        //default connection
        $connection='mysql';

        //local settings
        if(\app::environment()=="local"){

            $db['mysql']['driver']='mysql';
            $db['mysql']['host']='localhost';
            $db['mysql']['database']='Prosystem';
            $db['mysql']['user']='root';
            $db['mysql']['password']='root';

        }

        //production settings
        if(\app::environment()=="production"){

            $db['mysql']['driver']='mysql';
            $db['mysql']['host']='localhost';
            $db['mysql']['database']='database';
            $db['mysql']['user']='user';
            $db['mysql']['password']='password';

        }

        //return db
        return $db[$connection];



    }
}