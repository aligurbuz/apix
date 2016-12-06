<?php
namespace src\app\v1\bar;
use lib\config\config as config;

class index extends app {

    public function get(){

        return config::get("app");
    }
}