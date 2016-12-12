<?php

namespace src\config;

class app {

    public $resolver;

    public function __construct(){
        $this->resolver='test';
    }

    public static function getClassAlias(){

        return [

            //'request' =>'\\src\\services\\request'
        ];

    }


    private static function getContainerClassAlias(){

        return [

            'device' =>'\\src\\services\\mobileDetect'
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
            $containeralias=str_replace("\\","\\\\",$class);

            //check container class alias
            if(array_key_exists($containeralias,self::getContainerClassAlias())){
                $class=self::getContainerClassAlias()[$class];
                return new $class();

            }

            //return pure container
            return new $class();
        }


    }

}
