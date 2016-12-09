<?php

namespace lib;

class connection {

    /**
     * connect to api service (created service).
     *
     * Enabled by default.
     *
     * @param bool $bool
     * @return connectin runner
     */
    public static function run() {

        //service main file extends this file
        require(root . '/src/app/trendmax/v1/bar/app.php');

        //service main file
        require(root . '/src/app/trendmax/v1/bar/index.php');

        //resolve process
        $resolve=require(root.'/lib/resolver.php');
        $resolve=new \classresolver();
        $apix=$resolve->resolve("\\src\\app\\trendmax\\v1\\bar\\index");

        //check config file for method name
        $mainFunctionMethod=\src\config\config::get("mainFunctionMethod");

        //call service
        return $apix->$mainFunctionMethod();
    }
}