<?php
namespace src\commands;

class test {

    public function __construct(){
        $this->handle();
    }

    public function handle(){
        return 'hello world';
    }
}