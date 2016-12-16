<?php
/**
 * database config controller
 * it is mainly database connection for service
 * service database provider
 */

namespace src\app\__projectName__\v1\config;


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
    public function dbSettings(){

        //default connection
        $connection='mysql';

        //local settings
        if(\app::environment()=="local"){

            $db['mysql']['host']='localhost';
            $db['mysql']['database']='database';
            $db['mysql']['user']='user';
            $db['mysql']['password']='password';

        }

        //production settings
        if(\app::environment()=="production"){

            $db['mysql']['host']='localhost';
            $db['mysql']['database']='database';
            $db['mysql']['user']='user';
            $db['mysql']['password']='password';

        }

        //return db
        return $db[$connection];



    }
}