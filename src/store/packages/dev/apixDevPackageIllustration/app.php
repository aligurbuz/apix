<?php
/*
 * This file is app class extended of the dev service.
 *
 * every service is extends app class as default
 * service name : dev
 * namespace : src\store\packages\dev\apixDevPackageIllustration
 * app class namespace : \src\store\packages\dev\apixDevPackageIllustration\app
 */

namespace src\store\packages\dev\apixDevPackageIllustration;

use src\app\dev\v1\serviceBaseController as base;

/**
 * Represents a app abstract class.
 *
 * it is helper for main file
 * return type array
 */

class app extends toolBox
{
    public $source;
    public $model;
    public $main;

    /**
     * Abstract Constructor.
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
        parent::__construct();
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
