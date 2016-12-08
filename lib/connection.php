<?php

namespace lib;

class connection {

    public static function run() {

        require(root.'/src/app/v1/bar/app.php');
        require(root.'/src/app/v1/bar/index.php');
        $container=\DI\ContainerBuilder::buildDevContainer();
        $apix=$container->get("\\src\\app\\v1\\bar\\index");
        $mainFunctionMethod=\src\config\config::get("mainFunctionMethod");
        return $apix->$mainFunctionMethod();
    }
}