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
            $otherEnvPath=self::resolve("\\src\\env");
            $environment=$otherEnvPath->environmentSetUp();
            if($environment!==null){
                return $environment;
            }
        }
        return 'production';
    }

}