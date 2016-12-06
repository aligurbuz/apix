<?php

namespace lib\config;

class config {

    public static function get($param){

        $list=[

            'app'   =>'apix'

        ];

        return $list[$param];
    }
}
