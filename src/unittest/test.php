<?php namespace src\unittest; 

class test extends \PHPUnit_Framework_TestCase {

    public function setUp(){

    }

    public function test_mockery(){
        $mock=\Mockery::mock(array("foo","bar"));
        var_dump($mock);
    }
}