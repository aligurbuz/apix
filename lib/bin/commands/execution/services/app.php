<?php
/**
 * service app.
 * main file extends this file
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;

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

    /**
     * example method.
     *
     * @param type dependency injection and function
     */
    public function __construct(){
        $this->source=\branch::source();
        $this->model=\branch::query();
        $this->handle=\branch::handle();
    }


}