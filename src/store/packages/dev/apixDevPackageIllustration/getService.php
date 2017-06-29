<?php
/**
 * This file is main class of the  service named apixDevPackageIllustration on  dev project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : dev
 * namespace : src\store\packages\dev\apixDevPackageIllustration
 * app class namespace : \src\store\packages\dev\apixDevPackageIllustration\app
 */

namespace src\store\packages\dev\apixDevPackageIllustration;

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
        return $this->source->apixDevPackageSourceIllustration()->get();
    }
}
