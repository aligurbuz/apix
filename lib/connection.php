<?php

namespace lib;
use lib\BaseDefinitor as Definitor;
use Symfony\Component\Yaml\Yaml;
use src\store\services\httprequest as request;

class connection extends Definitor {

    /**
     * @var container var
     * connection run
     * for service base controller
     */
    public $container;

    /**
     * @var resolve var
     * connection run
     * for service base controller
     */
    public $resolve;

    /**
     * @var instance var
     * connection run
     * for service base controller
     */
    private static $_instance=null;

    /**
     * @var globalVars var
     * connection run
     * for service base controller
     */
    private static $globalVars=null;

    /**
     * @var service var
     * connection run
     * for service base controller
     */
    private static $service=null;

    /**
     * @var serviceMethod var
     * connection run
     * for service base controller
     */
    private static $serviceMethod=null;

    /**
     * @var queryParams var
     * connection run
     * for service base controller
     */
    private static $queryParams=null;

    /**
     * @var getVersion var
     * connection run
     * for service base controller
     */
    private static $getVersion=null;


    /**
     * @internal param __construct $ method
     * connection run pre loader
     * for service base controller
     */
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
        $service=self::$service;
        $serviceMethod=self::$serviceMethod;
        $getVersion=self::$getVersion;

        return $instance->checkServiceUrlParamArray(function() use ($service,$serviceMethod,$getVersion,$instance) {

            //get auto loads from services
            $instance->getAutoLoadsFromServices();

            //get token control
            return $instance->token(function() use ($service,$serviceMethod,$getVersion,$instance) {

                //provision run
                return $instance->provision(function() use ($service,$serviceMethod,$getVersion,$instance) {

                    return $instance->rateLimiterQuery(function() use ($service,$serviceMethod,$getVersion,$instance) {

                       if($service[1]=="doc"){
                           header("Content-Type: text/html");
                           $apiDoc=staticPathModel::$apiDocNamespace;
                           return utils::resolve($apiDoc)->index();
                       }

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

                                $serviceBasePlatformStatus=utils::resolve(api."serviceBaseController")->platform;
                                if($serviceBasePlatformStatus){
                                    $servicePlatform=utils::resolve(staticPathModel::$apiPlatformNamespace);
                                    $requestServiceMethodReal=$servicePlatform->take(function() use(&$requestServiceMethodReal,$apix,$requestServiceMethod,$boot){
                                        $requestServiceMethodReal=$apix->$requestServiceMethod((object)$boot);
                                    });

                                    if($requestServiceMethodReal===null){
                                        $requestServiceMethodReal=$apix->$requestServiceMethod((object)$boot);
                                    }

                                }
                                else{
                                    $requestServiceMethodReal=$apix->$requestServiceMethod((object)$boot);
                                }

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

        $projectComposerPath=root.'/'.src.'/'.app.'/composer/autoload.php';
        if(file_exists($projectComposerPath)){
            require_once $projectComposerPath;
        }


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

        $request=new request();
        $basePath=$request->getHost().''.$request->getBasePath();

        //define project
        define("basePath",$basePath);
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