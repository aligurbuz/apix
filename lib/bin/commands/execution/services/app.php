<?php
/**
 * service app.
 * main file extends this file
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;
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
    public $superservicecall;

    /**
     * example method.
     *
     * @param type dependency injection and function
     */
    public function __construct(){
        $this->source=\branch::source();
        $this->model=\branch::query();
        $this->handle=\branch::handle();
        $this->superservicecall=new superservicecalls();

    }

    /**
     * provider __call method.
     *
     * @param type dependency injection and function
     */
    public function __call($name=null,$args){
        if($name!==null){
            return $this->superservicecall->$name();
        }
    }


}