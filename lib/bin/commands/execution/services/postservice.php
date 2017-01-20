<?php
/*
 * This file is main part of the __projectName__ service.
 *
 * every request is called index method as default
 * service name : __projectName__
 * namespace : src\app\__projectName__\v1\__call\__serviceName__
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;
use src\services\httprequest as request;

/**
 * Represents a post service class.
 *
 * main call
 * return type array
 */

class postService extends \src\app\__projectName__\v1\__call\__serviceName__\app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and app class
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
     *
     * @return array
     */
    public function index(){

        //return index
        return [
            'post'=>true
        ];
    }
}