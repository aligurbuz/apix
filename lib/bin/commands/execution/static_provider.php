<?php
/**
 * Service static provider controller
 * it is mainly service provider for service
 * service provider as static
 */

namespace src\app\__projectName__\__version__\staticProvider;
use src\store\services\httprequest as request;


class __file__
{
    private $request;
    /**
     * Constructor.
     *
     * @param type dependency injection and app class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(){
        $this->request=new request();
    }

    /**
     * provider example method.
     *
     * @param prepared functions and objects
     * request method : static provider call
     * main overloading method as static provider
     * @return string
     */
    public static function exampleStaticProvider(){
        return 'exampleStaticProvider';
    }
}