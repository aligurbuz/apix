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

    require(root.'/lib/autoload.php');
    $connection=new src\connection();
    echo $connection->config();