<?php

namespace src;
use lib\config\config as config;

class connection {

    private $config;

    public function __construct(){
        //self::config='config';
    }

    public static function run() {

        require(root.'/src/app/v1/bar/app.php');
        require(root.'/src/app/v1/bar/index.php');
        $apix=new \src\app\v1\bar\index();
        return $apix->get();
    }
}