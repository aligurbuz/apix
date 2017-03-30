<?php
/*
 * This file is main class of the  service named sales on  dev project .
 * METHOD : POST
 * every service is called with index method as default
 * service name : dev
 * namespace : src\packages\dev\sales
 * app class namespace : \src\packages\dev\sales\app
 */

namespace src\packages\dev\sales;
use Src\Services\Httprequest as request;
use Src\Services\Repository as repo;

/**
 * Represents a postService class.
 * http method : post
 * every method that on this service is called with post method as http method on browser
 * every service extends app class
 * attention:provision condition can be needed for post method
 * return type array
 */
class postService extends app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and sales class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(request $request){

        parent::__construct();
        $this->request=$request;
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
    public function index(){

        //return index
        return ['post'=>true];
    }
}