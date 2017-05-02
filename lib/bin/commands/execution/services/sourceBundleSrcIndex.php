<?php
/*
 * This file is bundle part src of the __projectName__ service.
 *
 * every request can call one bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\v1\__call\__serviceName__\source\bundle\__bundleName__\src\__srcName__;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\Repository as Repo;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class __className__ extends \src\app\__projectName__\v1\__call\__serviceName__\app
{

    /**
     * Constructor.
     *
     * @param type dependency injection and function
     */
    public function __construct()
    {

        //get app extends
        parent::__construct();
    }

    /**
     * for bundle src service
     * get method is main run.
     *
     * @return string|array|object
     */
    public function get()
    {

        //return source
        return "__projectName__ bundle __serviceName__ __bundleName__ __srcName__";
    }
}
