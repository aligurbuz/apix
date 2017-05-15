<?php
/*
 * This file is main class of the  service named __serviceName__ on  __projectName__ project .
 * METHOD : __method__
 * every service is called with index method as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\v1\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\v1\__call\__serviceName__\app
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\Repository as Repo;
use Collection;

/**
 * Represents a __method__Service class.
 * http method : __method__
 * every method that on this service is called with __method__ method as http method on browser
 * every service extends app class
 * attention:provision condition can be needed for __method__ method
 * return type array
 */
class __method__Service extends app
{
    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and __serviceName__ class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct()
    {

        //get app extends
        parent::__construct();
    }

    /**
     * index method is main method.
     * it is default method without needed interface implemantation
     * because method name is called on the url
     * method can produce ouput as string or array
     * converted to array everytime as output
     * produced json output as result
     * @return array @method
     */
    public function index()
    {

        //return index
        return ['__method__'=>true];
    }
}
