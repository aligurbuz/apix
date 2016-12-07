<?php
namespace src\app\v1\bar;

class index extends app {

    public function get(){

        $container = \DI\ContainerBuilder::buildDevContainer();
        return \src\config\config::get("app");
    }
}