# Apix Restfull Service
Comprehensive restfull api service for php development
* - Main Developer : Ali Gurbuz

> Package allows you to design easily restfull services.Creating api services is very easy any more.
> For creating easily your api,please keep track of following instructions.

# System requirements
* php >5.6.*
* nginx or apache (for http)
* docker or vagrant container to manage terminal commands



#### Clone with writing following command on terminal to local repository the package on github

```
git clone https://github.com/aligurbuz/apix.git folderName

cd folderName

```

#### Please update it for your composer to use vendor system because of that the apix system utilizes Composer to manage its dependencies.

```
composer update

```


#### Run following commands on terminal to use system requirements with creating project,service and database migrations.Path/to on shortcut command is network directory path

```
alias api='php /path/to/foldername/lib/bin/service'
alias migration='php /path/to/foldername/vendor/bin/phinx'

```

# What is foldername
```diff
-Foldername is your system general name or company name (directory cloned github repository).
-Every service is called from on route foldername like http://ip/foldername/service/project/servicename/index
```

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
 * This file is main class of the myapp service.
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
     * @param type dependency injection and app class
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
