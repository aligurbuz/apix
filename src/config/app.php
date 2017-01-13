<?php

namespace src\config;
use src\services\httprequest as request;

class app {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(){

        //get request info
        $this->request=new request();
    }

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

    /**
     * response arraydelete.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function arrayDelete($data,$delete){

        $list=[];
        foreach($data as $key=>$value){
            if(!in_array($key,$delete)){
                $list[$key]=$value;
            }
        }

        return $list;
    }

    /**
     * response checkUrlParam.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function checkUrlParam($param){
        $border=new self;
        if(array_key_exists($param,$border->request->getQueryString())){
            return true;
        }
        return false;
    }

    /**
     * response getUrlParam.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    public static function getUrlParam($param){
        $border=new self;
        $string=$border->request->getQueryString();
        if(array_key_exists($param,$string)){
            return $string[$param];
        }
        return null;
    }


}
