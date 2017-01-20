<?php
/*
 * This file is main part of the __projectName__ service.
 * every request is called index method as default
 * developer : aligurbuz [sde]
 */

namespace src\app\__projectName__\v1\__call\__serviceName__;
use src\services\httprequest as request;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class index extends app {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
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
    public function getIndex(){

        //return index
        return [
            'environment'=>\app::environment(),
            'clientIp'=>$this->request->getClientIp(),
            'isMobile'=>\container::device()->isMobile()
        ];
    }
}