<?php
/*
 * This file is main class of the  service named admin on  development project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : development
 * namespace : src\packages\dev\admin
 * app class namespace : \src\packages\dev\admin\app
 */

namespace src\packages\dev\admin;
use src\services\httprequest as request;

/**
 * Represents a getService class.
 *
 * main call
 * return type array
 */

class getService extends \src\packages\dev\admin\app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and admin class
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
            'environment'=>\app::environment(),
            'clientIp'=>$this->request->getClientIp(),
            'isMobile'=>app("device")->isMobile()
        ];
    }
}