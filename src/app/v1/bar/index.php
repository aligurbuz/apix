<?php
namespace src\app\v1\bar;
use src\app\v1\bar\test as test;

class index extends app {

    public $test;

    public function __construct(test $test){

        $this->test=$test;
    }

    public function get(){

        //di container
        return $this->test->inst();
    }
}