<?php
/*
 * This file is bundle part of the __projectName__ service.
 *
 * every request can call one bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\__projectName__\__version__\__call\__serviceName__\source\bundle\__bundleName__;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\Repository as Repo;
use src\app\__projectName__\__version__\__call\__serviceName__\app;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class index extends app implements __bundleName__Interface
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
     * for bundle service
     * handle method is auto run.
     *
     * @return string|array|object
     */
    public function get()
    {

        //return source
        return "__projectName__ bundle __serviceName__ __bundleName__";
    }
}
