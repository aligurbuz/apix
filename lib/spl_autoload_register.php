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

class autoloadRegister {

    /**
     * @var $class
     */
    private $class;

    /**
     * @var $classPath
     */
    private $classPath;


    public function register(){

        // Use default autoload implementation
        spl_autoload_register(function($class){
            $this->getCallBackVar($class);
            $this->registerCallBackFormatter();
        });
    }

    private function getCallBackVar($class){

        $this->class=$class;
        $this->classPath=root.'/'.$this->class.'.php';
        $this->classPath=str_replace("\\","/",$this->classPath);
    }

    private function registerCallBackFormatter () {

        $this->checkAliasClassFormatter($this->classPath,function() {
            require($this->classPath);
        });
    }


    private function checkAliasClassFormatter($class,$callback){

        if(!file_exists($class)){

            $alias=str_replace(root.'/','',$class);
            $alias=str_replace('.php','',$alias);

            //check system app control for class alias
            $systemApp=\src\store\config\app::getClassAliasLoader();
            if(defined('app')){
                $appAlias='\\src\\app\\'.app.'\\'.version.'\\config\\app';
                $systemApp=array_merge($systemApp,$appAlias::getAppClassAlias());
            }

            //set class_alias groups
            if(array_key_exists($alias,$systemApp)){
                class_alias($systemApp[$alias],$alias);
            }
        }
        else {
            return call_user_func($callback);
        }
    }

}

echo (new autoloadRegister())->register();

