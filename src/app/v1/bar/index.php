<?php
namespace src\app\v1\bar;

class index extends app {

    public $test;

    public function __construct(){

    }

    public function get(){

        //di container
        return 'hello world';
    }
}