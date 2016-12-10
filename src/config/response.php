<?php

namespace src\config;

class response {

    public static function get($service){

        $list=[

            //this response output for service
            'response'=>[
                'allServices'=>'json'
            ]

        ];

        //return service
        return $list[$service];

    }
}
