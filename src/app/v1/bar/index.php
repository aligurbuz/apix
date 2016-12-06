<?php
namespace src\app\v1\bar;

class index {


    public function get(){

        return \lib\config\config::get("app");
    }
}