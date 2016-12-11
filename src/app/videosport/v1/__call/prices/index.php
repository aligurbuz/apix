<?php
namespace src\app\videosport\v1\__call\prices;

class index extends app {

    public $test;

    public function __construct(){

    }

    public function index(){

        //di container
        print_r([
            'root'=>root,
            'request_uri'=>$_SERVER['REQUEST_URI']
        ]);
    }
}