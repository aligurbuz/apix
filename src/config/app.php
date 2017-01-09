<?php

namespace src\config;

class app {

    public static function getClassAlias(){

        return [

            //'request' =>'\\src\\services\\request'
        ];

    }


    public static function getContainer(){

        return [

            'device'    =>'\\src\\services\\mobileDetect',
            'redis'     =>'\\src\\services\\redis'
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

    /**
     * response environment.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function resolve($class){

        $container = \DI\ContainerBuilder::buildDevContainer();
        return $container->get($class);

    }


}
