<?php

namespace lib;
use lib\BaseDefinitor as Definitor;
use Symfony\Component\Yaml\Yaml;

class connection extends Definitor {

    public $container;
    public $resolve;
    private static $_instance=null;
    private static $globalVars=null;
    private static $service=null;
    private static $serviceMethod=null;
    private static $queryParams=null;
    private static $getVersion=null;

    public function __construct(){
        //class resolve
        $this->resolve=$this->getClassDependencyResolver();
        //get service and file method from request uri
        self::$service=$this->getServiceNameAndMethodFromRequestUri();
        //get only method name from service
        self::$serviceMethod=$this->getPureMethodNameFromService();
        //get query params from service
        self::$queryParams=$this->getQueryParamsFromRoute();
        //assign version number
        self::$getVersion=$this->getVersionForProject();
    }

    /**
     * connect to api service (created service).
     *
     * Enabled by default.
     *
     * @param bool $bool
     * @return connectin runner
     */
    public static function run() {
        //get instance
        $instance=self::getInstance();

        return $instance->checkServiceUrlParamArray(function() use ($instance) {

            //get auto loads from services
            $instance->getAutoLoadsFromServices();

            //token run
            $service=self::$service;
            $serviceMethod=self::$serviceMethod;
            $getVersion=self::$getVersion;

            //get token control
            return $instance->token(function() use ($service,$serviceMethod,$getVersion,$instance) {

                //provision run
                return $instance->provision(function() use ($service,$serviceMethod,$getVersion,$instance) {

                    return $instance->rateLimiterQuery(function() use ($service,$serviceMethod,$getVersion,$instance) {

                        //check package auto service and method
                        if($instance->checkPackageAuto($service)['status']){
                            $packageAuto=$instance->resolve->resolve($instance->checkPackageAuto($service)['class']);
                            return $instance->responseOut($packageAuto->$serviceMethod());
                        }

                        //check package dev service and method
                        if($instance->checkPackageDev($service)['status']){
                            $packageDev=$instance->resolve->resolve($instance->checkPackageDev($service)['class']);
                            define("devPackage",true);
                            return $instance->responseOut($packageDev->$serviceMethod($instance->checkPackageDev($service)['definitions']));
                        }

                        $serviceNo=$instance->getFixLog('serviceNo');
                        if(!file_exists(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'')){
                            return $instance->responseOut([],$serviceNo);
                        }

                        if(!file_exists(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php')){
                            return $instance->responseOut([],$serviceNo);
                        }

                        //service main file extends this file
                        require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php');

                        //apix resolve
                        $apix=$instance->resolve->resolve("\\src\\app\\".$service[0]."\\".$getVersion."\\__call\\".$service[1]."\\".request."Service");

                        $requestServiceMethod=$serviceMethod;
                        if(method_exists($apix,$requestServiceMethod)){
                            if(property_exists($apix,"forbidden") && \lib\environment::get()=="production"){
                                if($apix->forbidden){
                                    return $instance->responseOut([],$instance->getFixLog('noaccessright'));
                                }
                            }
                            //call service
                            $restrictions=$apix->restrictions();
                            $restrictionsStatus=true;
                            if(is_array($restrictions) && array_key_exists($requestServiceMethod,$restrictions)){
                                $restrictionsStatus=$restrictions[$requestServiceMethod];
                            }
                            if($restrictionsStatus){
                                $boot=$instance->bootServiceLoader($requestServiceMethod);

                                $requestServiceMethodReal=$apix->$requestServiceMethod((object)$boot);
                                $instance->serviceDump($requestServiceMethodReal,$requestServiceMethod);
                                return $instance->logging($requestServiceMethodReal,function() use ($instance,$requestServiceMethodReal){
                                    return $instance->responseOut($requestServiceMethodReal);
                                });
                            }

                            return $instance->responseOut([],$instance->getFixLog('serviceRestrictions'));

                        }
                        else{
                            return $instance->responseOut([],$instance->getFixLog('invalidservice'));
                        }

                    });


                });
            });
        });
    }

    /**
     * get instance classes.
     *
     * outputs get instance.
     *
     * @param string
     * @return response instance runner
     */
    private function getVersionForProject(){
        //get version number from config
        $defaultVersionCheck=$this->getConfigVersionNumber(['serviceName'=>self::$service[0]]);
        return (array_key_exists("version",self::$queryParams)) ? self::$queryParams['version'] : $defaultVersionCheck;

    }


    /**
     * get service autoloads classes.
     *
     * outputs get autoloads.
     *
     * @param string
     * @return response autoloads runner
     */
    private function getAutoLoadsFromServices(){

        //get defines
        $this->getDefinitions();

        //get preloader classes
        $this->getPreLoaderClasses();

        //check environment
        \lib\environment::config();

        //get before middleware
        $this->middleware("before");

    }


    /**
     * get definitions classes.
     *
     * outputs get definitive.
     *
     * @param string
     * @return response define runner
     */
    private function getDefinitions(){
        //define project
        define("app",self::$service[0]);
        self::$service[1]=(array_key_exists(1,self::$service)) ? self::$service[1] :null;
        define("service",self::$service[1]);
        define("version",self::$getVersion);
        define("method",self::$serviceMethod);
        define("application",root.'/'.src.'/'.app.'');
        define("api","\\src\\app\\".app."\\".version."\\");
        define("apiPath",root."/src/app/".app."/".version."/");
        define("request",$_SERVER['REQUEST_METHOD']);
        $this->getAppDefinitionLoader();


    }


    /**
     * get instance classes.
     *
     * outputs get instance.
     *
     * @param string
     * @return response instance runner
     */
    private function checkServiceUrlParamArray($callback){
        if(strlen(self::$service[0])==0){
            return $this->responseOut([],$this->getFixLog('projectPathError'));
        }
        if(!file_exists(root . '/'.src.'/'.self::$service[0].'')){
            return $this->responseOut([],$this->getFixLog('projectNo'));
        }
        return call_user_func($callback);
    }


    /**
     * get instance classes.
     *
     * outputs get instance.
     *
     * @param string
     * @return response instance runner
     */
    private static function getInstance(){
        if(self::$_instance==null){ self::$_instance=new self;}
        return self::$_instance;

    }










}