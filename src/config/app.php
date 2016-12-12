<?php

namespace src\config;

class app {

    public static function getClassAlias(){

        return [

            //'request' =>'\\src\\services\\request'
        ];

    }

    /**
     * response environment.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function environment(){

        $envpath=root.'/env.php';

        if(file_exists($envpath)){
            return 'local';
        }else{
            return 'production';
        }

    }

}
