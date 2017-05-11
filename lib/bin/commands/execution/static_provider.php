<?php
/**
 * Service static provider controller
 * it is mainly service provider for service
 * service provider as static
 */

namespace src\app\__projectName__\__version__\optional\staticProvider;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\Repository as Repo;


class __file__
{
    /**
     * Constructor.
     *
     * @param type dependency injection and app class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(){}

    /**
     * provider example method.
     *
     * @param prepared functions and objects
     * request method : static provider call
     * main overloading method as static provider
     * @return string
     */
    public static function exampleStaticProvider()
    {
        //return static provider
        return 'exampleStaticProvider';
    }
}