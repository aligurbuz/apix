<?php
/*
 * This file is bundle part of the dev service.
 *
 * every request can call one bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\packages\dev\stool\source\bundle\tool;
use Src\Services\Httprequest as request;
use Src\Services\Repository as repo;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class index extends \src\packages\dev\stool\app implements toolInterface  {

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
     * for bundle service
     * handle method is auto run.
     *
     * @return string|array|object
     */
    public function get(){

        //return source
        return "dev bundle stool tool";
    }
}