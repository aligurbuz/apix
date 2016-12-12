<?php
/*
 * This file is main part of the __projectName__ service.
 *
 * every request is called index method as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
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
            'isMobile'=>\app::container("device")->isMobile()
        ];
    }
}