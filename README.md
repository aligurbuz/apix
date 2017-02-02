# Apix Restfull Service
Comprehensive restfull api service for php development
* - Main Developer : Ali Gurbuz

> Package allows you to design easily restfull services.Creating api services is very easy any more.
> For creating easily your api,please keep track of following instructions.

# Documentation :
[Installation and system requirements : ](https://github.com/aligurbuz/apix/docs/installation.md)

#### Everyting is okey to create your project now.Create first project with running the following command on terminal

```
api project create myapp

```

```diff
+ with running api project create myapp
+ it creates myapp project in src/app
+ as output : project has been created
```

## Now,create your first service in your project

```
api service create myapp:ghost

```

```diff
+ with running api service create myapp:ghost
+ it creates service named ghost in src/app/myapp/v1/__call on your myapp project
+ as output : service has been created
```

## You can see on browser your project

```
GET / http://ip/foldername/service/myapp/gost/index (called getService class in __call directory)
POST / http://ip/foldername/service/myapp/gost/index (called postService class in __call directory)

```

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
