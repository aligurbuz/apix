<?php
/*
 * This file is repo part src of the dev repository.
 *
 * every request can call repository
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\packages\dev\stool\devpack\repository\guzzle;
use src\services\httprequest as request;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class index implements guzzleInterface  {

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
     * for repository service
     * handle method is auto run.
     *
     * @return string|array|object
     */
    public function get(){

        //return source
        return "dev repository guzzle";
    }
}