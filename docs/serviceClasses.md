# Get Service Form

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
use src\services\httprequest as request;

/**
 * Represents a getService class.
 *
 * main call
 * return type array
 */

class getService extends \src\app\mobi\v1\__call\stk\app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(request $request){

        //get request info
        parent::__construct();
        $this->request=$request;
    }

    /**
     * index method is main method.
     *
     * @return array
     */
    public function index(){

        //return index
        return [
            'environment'=>\app::environment(),
            'clientIp'=>$this->request->getClientIp(),
            'isMobile'=>app("device")->isMobile()
        ];
    }
}

```

# Post Service Form

```
<?php
/*
 * This file is main class of the  service named stk on  mobi project .
 * METHOD : POST
 * every service is called with index method as default
 * service name : mobi
 * namespace : src\app\mobi\v1\__call\stk
 * app class namespace : \src\app\mobi\v1\__call\stk\app
 */

namespace src\app\mobi\v1\__call\stk;
use src\services\httprequest as request;

/**
 * Represents a getService class.
 *
 * main call
 * return type array
 */

class postService extends \src\app\mobi\v1\__call\stk\app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * request method : symfony component
     * main loader as construct method
     */
    public function __construct(request $request){

        //get request info
        parent::__construct();
        $this->request=$request;
    }

    /**
     * index method is main method.
     *
     * @return array
     */
    public function index(){

        //return index
        return ['post'=>true];
    }
}

```