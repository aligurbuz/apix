<?php
/*
 * This file is app class extended of the dev service.
 *
 * every service is extends app class as default
 * service name : dev
 * namespace : src\packages\dev\sales
 * app class namespace : \src\packages\dev\sales\app
 */

namespace src\packages\dev\sales;
use src\services\superservicecalls as superservicecalls;

/**
 * Represents a app class.
 *
 * it is helper for main file
 * return type array
 */

class app {

    public $source;
    public $model;
    public $handle;
    public $main;
    private $superservicecall;
    protected $ready;

    /**
     * Constructor.
     *
     * @param type dependency injection and app class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(){
        $this->source=\branch::source();
        $this->model=\branch::query();
        $this->main=\branch::main();
        $this->superservicecall=new superservicecalls();
        $this->ready=$this->superservicecall->ready();
    }

    /**
     * provider __call method.
     *
     * @param prepared functions and objects
     * request method : super service call
     * main overloading method as superservicecall
     */
    public function __call($name=null,$args){
        if($name!==null){
            return $this->superservicecall->$name();
        }
    }


    /**
     * service restrictions method.
     *
     * @param prepared functions and objects
     * request method : super service call
     * main overloading method as restrictions
     * @return array
     */
    public function restrictions(){
        $list=[];
        return $list;
    }


}