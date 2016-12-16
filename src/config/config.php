<?php

namespace src\config;

class config {

    public static function get($param){

        $list=[

            //this object main key
            'mainFunctionMethod'   =>'get',
            'objectloader'=>true,
            'appVersions'=>[
                'trendMax'=>'v1'
            ]

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
}
