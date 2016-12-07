<?php
namespace src\app\v1\bar;

class index extends app {

    private $container;

    public function __construct(){

        $this->container=\DI\ContainerBuilder::buildDevContainer();
    }

    public function get(){

        return $this->container->get("\\src\\app\\v1\\bar\\test")->inst();
    }
}