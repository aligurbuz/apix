<?php

namespace lib;

class connection {

    public static function run() {

        require(root.'/src/app/v1/bar/app.php');
        require(root.'/src/app/v1/bar/index.php');
        $apix=new \src\app\v1\bar\index();
        return $apix->get();
    }
}