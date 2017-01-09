<?php

namespace src\config;

class config {

    public static function get($param){

        $list=[

            //this object loader
            'objectloader'=>false

        ];

        return self::configOut($param,$list);

    }

    private static  function configOut($param,$list){


        if(array_key_exists($param,$list)){
            return $list[$param];
        }
        else
        {
            return null;
        }
    }


    public static function service($param=null){

        if($param!==null){
            $return=require(root.'/src/app/'.app.'/'.version.'/__call/'.service.'/serviceConf.php');
            if(is_array($return) && array_key_exists($param,$return)){
                return $return[$param];
            }
        }


        return null;


    }
}
