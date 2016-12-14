<?php

namespace src\config;

class app {

    public static function getClassAlias(){

        return [

            //'request' =>'\\src\\services\\request'
        ];

    }


    private static function getContainer(){

        return [

            'device'    =>'\\src\\services\\mobileDetect',
            'redis'     =>'\\src\\services\\redis',
            'session'   =>'\\src\\services\\session'
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
     * app container.
     *
     * container class new instance.
     *
     * @param class return
     * @return app container runner
     */

    public static function container($class=null){

        if($class!==null){
            //class resolve
            $container = \DI\ContainerBuilder::buildDevContainer();

            //container namespace edit
            $containeralias=str_replace("\\","\\\\",$class);

            $inApp="\\src\\app\\".app."\\v1\\config\\app";
            $inApp=$container->get($inApp);
            $inAppContainer=$inApp->container();

            $inAppContainerList=[];
            foreach ($inAppContainer as $inkey=>$invalue){
                if(!array_key_exists($inkey,self::getContainer())){

                    $inAppContainerList[$inkey]=$invalue;
                }
            }

            $lastContainer=self::getContainer()+$inAppContainerList;

            //check container class alias
            if(array_key_exists($containeralias,$lastContainer)){
                $class=$lastContainer[$class];
                return $container->get($class);

            }

            //return pure container
            return new $class();
        }


    }

}
