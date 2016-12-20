<?php
/*
 * This file is main part of the mobi service.
 *
 * every request is called index method as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\mobi\v1\__call\stk\branches\query;
use src\app\mobi\v1\model\task;
use src\services\httprequest as request;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class index {

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
    public function get(){

        return task::get();

    }
}