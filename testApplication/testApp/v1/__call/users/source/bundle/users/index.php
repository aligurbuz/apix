<?php
/*
 * This file is bundle part of the testApp service.
 *
 * every request can call one bundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\app\testApp\v1\__call\users\source\bundle\users;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;
use src\app\testApp\v1\__call\users\app;

/**
 * Represents a bundle index class.
 *
 * main call
 * return type array
 */

class index extends app implements usersInterface
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
        return [
            'environment'=>environment(),
            'userList'=>$this->model->user()->get()
        ];
    }
}
