<?php
/**
 * This file is main class of the  service named users on  testApp project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : testApp
 * namespace : src\app\testApp\v1\__call\users
 * app class namespace : \src\app\testApp\v1\__call\users\app
 */

namespace src\app\testApp\v1\__call\users;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;


/**
 * @doc getService
 * @package Src_App_Mobi_V1_Call_Stk
 */
class getService extends app implements getServiceInterface
{

    /**
     * Production forbidden.
     *
     * @if it is true,you can't access on the production
     * @restrictions method is comprenhensive on app class
     */
    public $forbidden=false;


    /**
     * Construct Load
     */
    public function __construct()
    {
        //get app extends
        parent::__construct();
    }

    /**
     * @return array
     */
    public function indexAction()
    {
        /**
         * @cache default file cache
         * @storage users/cache
         */
        return app('cache')->expire(30)->get(function() {
            return $this->source->users()->get();
        });

    }
}
