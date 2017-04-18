<?php


    /*
    |--------------------------------------------------------------------------
    | Application Starting
    |--------------------------------------------------------------------------
    |
    | This class is the starter of your application. This class is used when the
    | apix firstly calls.all request coming to application are run here.
    | Apix starter place
    |
    */

    // Use default autoload implementation
    spl_autoload_register(function($class){

        //echo $class.''.PHP_EOL;
        $class=root.'/'.$class.'.php';

        $class=str_replace("\\","/",$class);

        require($class);

    });

    //get connection
    echo \lib\connection::run();
