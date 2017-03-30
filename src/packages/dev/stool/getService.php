<?php
/*
 * This file is main class of the  service named stool on  dev project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : dev
 * namespace : src\packages\dev\stool
 * app class namespace : \src\packages\dev\stool\app
 */

namespace src\packages\dev\stool;
use Src\Services\Httprequest as request;
use Src\Services\Repository as repo;

/**
 * Represents a getService class.
 * http method : get
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class getService extends app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and stool class
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
     * it is default method without needed interface implemantation
     * because method name is called on the url
     * method can produce ouput as string or array
     * converted to array everytime as output
     * produced json output as result
     * @return array @method
     */
    public function index(){

        //result
        return app("cache")->expire(30)->get(function(){
            return repo::guzzle()->get();
        });

    }
}