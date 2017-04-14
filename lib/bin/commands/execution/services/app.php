<?php
/*
 * This file is app class extended of the __projectName__ service.
 *
 * every service is extends app class as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\v1\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\v1\__call\__serviceName__\app
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;

/**
 * Represents a app class.
 *
 * it is helper for main file
 * return type array
 */

class app
{
    public $source;
    public $model;
    public $main;

    /**
     * Constructor.
     *
     * @param type dependency injection and app class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct()
    {
        $this->source=\branch::source();
        $this->model=\branch::query();
        $this->main=\branch::main();
    }


    /**
     * service restrictions method.
     *
     * @param prepared functions and objects
     * request method : super service call
     * main overloading method as restrictions
     * @return array
     */
    public function restrictions()
    {
        $list=[];
        return $list;
    }
}
