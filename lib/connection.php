<?php

namespace lib;

class connection {

    public static function run() {

        require(root . '/src/app/trendmax/v1/bar/app.php');
        require(root . '/src/app/trendmax/v1/bar/index.php');
        $resolve=require(root.'/lib/resolver.php');
        $resolve=new \classresolver();
        $apix=$resolve->resolve("\\src\\app\\trendmax\\v1\\bar\\index");
        $mainFunctionMethod=\src\config\config::get("mainFunctionMethod");
        return $apix->$mainFunctionMethod();
    }
}