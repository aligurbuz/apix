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
spl_autoload_register(function($class) {


    $class=root.'/'.$class.'.php';

    $class=str_replace("\\","/",$class);

    if(!file_exists($class)){

        $alias=str_replace(root.'/','',$class);
        $alias=str_replace('.php','',$alias);

        //check system app control for class alias
        $systemApp=\src\store\config\app::getClassAliasLoader();
        $appAlias='\\src\\app\\'.app.'\\'.version.'\\config\\app';
        $systemApp=array_merge($systemApp,$appAlias::getAppClassAlias());

        //set class_alias groups
        if(array_key_exists($alias,$systemApp)){
            class_alias($systemApp[$alias],$alias);
        }
    }
    else{
        require($class);
    }

});