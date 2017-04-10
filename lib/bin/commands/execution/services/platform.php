<?php
/*
 * This file is platform part of the __projectName__ service.
 *
 * every request can give reference to platform specified
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\platform\__platformdir__\__serviceName__;
use Request;
use Repo;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class __platformfile__ extends \src\app\__projectName__\v1\__call\__serviceName__\app {

    public $request;

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(Request $request){

        //get request info
        parent::__construct();
        $this->request=$request;

    }

    /**
     * index method is main method.
     *
     * @return array
     */
    public function index($data=array()){

        //return source
        return "__projectName__ source __serviceName__ platform __platformdir__ __platformfile__";
    }
}