<?php
/*
 * This file is main part of the __projectName__ service.
 *
 * every request is called index method as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\__call\__serviceName__\branches\source\__methodName__;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\Repository as Repo;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class __sourceName__ extends \src\app\__projectName__\v1\__call\__serviceName__\app
{


    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct(Request $request)
    {

        //get request info
        parent::__construct();
    }

    /**
     * index method is main method.
     *
     * @return array
     */
    public function get()
    {

        //return source
        return "__projectName__ source __serviceName__ __methodName__";
    }
}
