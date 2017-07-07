<?php
/**
 * Service Adapter controller
 * In software engineering, the adapter pattern is a software design pattern that allows the interface of an existing class to be used from another interface.
 * It is often used to make existing classes work with others without modifying their source code.
 * service provider
 */

namespace src\app\testApp\v1;

use Src\Store\Services\Httprequest as Request;

class serviceAdapterController
{

    /**
     * Constructor.
     *
     * @param type adapter controller and adapter class
     */
    public function __construct() { }

    /**
     * Search name
     * @introduce : serviceBaseController search key
     * @introduce: default elasticSearch adapter
     * @return search class
     */
    public function search()
    {
        //adapter class for search
        return app('search')->driver();
    }


}
