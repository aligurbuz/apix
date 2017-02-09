<?php

namespace lib;

class environment {


    /**
     * service environment constructs.
     *
     * outputs get file.
     *
     * @internal param $string
     */
    public function __construct(){

    }

    /**
     * service environment runner method.
     *
     * outputs get file.
     *
     * @param string
     * @return response service environment runner
     */
    public static function get(){

        $envPath=root.'/.env';
        if(file_exists($envPath)){
            return 'local';
        }
        else{
            $otherEnvPath=\src\config\app::resolve("\\src\\env\\env");
            $environment=$otherEnvPath->environmentSetUp();
            if($environment!==null){
                return $environment;
            }
        }
        return 'production';
    }


    /**
     * service environment config method.
     *
     * outputs get file.
     *
     * @param string
     * @return response service environment config runner
     */
    public static function config(){

        //check environment
        if(self::get()=="local"){
            $dotenv = new \Dotenv\Dotenv(root);
            $dotenv->load();
        }
        else{
            $otherenvpath=\app::resolve("\\src\\env\\env");
            $environment=$otherenvpath->environmentSetUp();
            if($environment!==null){
                $dotenv = new \Dotenv\Dotenv(root.'/src/env','.'.$environment);
                $dotenv->load();
            }
        }

    }

}