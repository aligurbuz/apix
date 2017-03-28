<?php
/*
 * This file is platform part of the __projectName__ service.
 *
 * every request can give reference to platform specified
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\platform;
use Src\Services\Httprequest as request;
use Src\Services\Repository as repo;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class config {

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
     * dir method is main method.
     *
     * @return array
     */
    public function handle(){

        //return source
        return true;
    }
}