<?php
/**
 * Service base controller
 * it is mainly service provider for service
 * service provider
 */

namespace src\app\__projectName__\v1;


class serviceReadyController
{
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