# Apix Restfull Service
Comprehensive restfull api service for php development
* - Main Developer : Ali Gurbuz

> Package allows you to design easily restfull services.Creating api services is very easy any more.
> For creating easily your api,please keep track of following instructions.

# Documentation :
[Installation and system requirements](https://github.com/aligurbuz/apix/blob/master/docs/installation.md)
[Create Project and Service](https://github.com/aligurbuz/apix/blob/master/docs/projectSetUp.md)



## getService
```
<?php
/*
 * This file is main class of the  service named ghost on  myapp project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : myapp
 * namespace : src\app\myapp\v1\__call\ghost
 * app class namespace : \src\app\myapp\v1\__call\ghost\app
 */

namespace src\app\myapp\v1\__call\ghost;
use src\services\httprequest as request;

/**
 * Represents a getService class.
 *
 * main call
 * return type array
 */

class getService extends \src\app\myapp\v1\__call\ghost\app {

    public $request;
    public $forbidden=false;

    /**
     * Constructor.
     *
     * @param type dependency injection and ghost class
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
            'isMobile'=>\container::device()->isMobile()
        ];
    }
}
```
