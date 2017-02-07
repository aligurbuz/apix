<?php
/*
 * This file is main class of the  service named __serviceName__ on  __projectName__ project .
 * METHOD : POST
 * every service is called with index method as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\v1\__call\__serviceName__
 * app class namespace : \src\app\__projectName__\v1\__call\__serviceName__\app
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;
use src\services\httprequest as request;

/**
 * Represents a getService class.
 * http method : post
 * every method that on this service is called with post method on browser
 * every service extends app class
 * return type array
 */
class postService extends \src\app\__projectName__\v1\__call\__serviceName__\app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and __serviceName__ class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(request $request){

        //get request info
        parent::__construct();
        $this->request=$request;
    }

    /**
     * index method is main method.
     * it is default method without needed implemantation
     * method can produce ouput as string or array
     * @return array
     */
    public function index(){

        //return index
        return ['post'=>true];
    }
}