# Service Form

```
<?php
/*
 * This file is main class of the  service named stk on  mobi project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : mobi
 * namespace : src\app\mobi\v1\__call\stk
 * app class namespace : \src\app\mobi\v1\__call\stk\app
 */

namespace src\app\mobi\v1\__call\stk;

use Src\Store\Services\Httprequest as Request;
use Src\Store\Services\appCollection as Collection;


/**
 * Represents a getService class.
 * http method : get
 * every method that on this service is called with get method as http method on browser
 * every service extends app class
 * return type array
 */
class getService extends app
{

    /**
     * Production forbidden.
     *
     * @if it is true,you can't access on the production
     * @restrictions method is comprenhensive on app class
     */
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct()
    {
        //get app extends
        parent::__construct();
    }

    /**
     * index method is main method
     * because method name is called on the url
     * method can produce output with response class
     * produced json output as result (default)
     * @return array @method
     */
    public function indexAction()
    {
        return [
            'environment'=>environment(),
            'isMobile'=>app("device")->isMobile()
        ];
    }
}


```

