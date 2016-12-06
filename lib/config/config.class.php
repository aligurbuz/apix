<?php
namespace lib\config;

class config {

    public static function get($param){

        $list=[

            'app'   =>'config'

        ];

        return $list[$param];
    }
}
