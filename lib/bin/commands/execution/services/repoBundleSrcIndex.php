<?php
/*
 * This file is repo part src of the __projectName__ repository.
 *
 * every request can call repository
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\repository\__bundleName__\src\__srcName__;
use Request;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class __className__   {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(Request $request){

        //get request info
        $this->request=$request;

    }

    /**
     * for repository src service
     * get method is main run.
     *
     * @return string|array|object
     */
    public function get(){

        //return source
        return "__projectName__ repository __bundleName__ __srcName__";
    }
}