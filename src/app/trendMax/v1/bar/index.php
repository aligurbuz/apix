<?php
namespace src\app\trendmax\v1\bar;

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