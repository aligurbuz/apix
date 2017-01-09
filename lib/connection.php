<?php

namespace lib;

class connection {

    public $container;
    public $resolve;
    public static $_instance=null;
    
    public function __construct(){
        //class resolve
        $resolve=require(root.'/lib/resolver.php');
        $resolve=new \classresolver();
        $this->resolve=$resolve;
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

        //this fake
        if(self::$_instance==null){
            self::$_instance=new self;
            $border=self::$_instance;

        }

        //get service and file method from request uri
        $service=$border->getServiceNameAndMethodFromRequestUri();

        //get only method name from service
        $serviceMethod=$border->getPureMethodNameFromService();

        //get query params from service
        $queryParams=$border->getQueryParamsFromRoute();

        //get version number from config
        $defaultVersionCheck=$border->getConfigVersionNumber(['serviceName'=>$service[0]]);

        //assign version number
        $getVersion=(array_key_exists("version",$queryParams)) ? $queryParams['version'] : $defaultVersionCheck;

        //get preloader class
        //$border->getPreLoaderClass();

        if(strlen($service[0])==0){
            return $border->responseOut([],'project path invalid : path/service/app/servicename/method');
        }

        if(!file_exists(root . '/'.src.'/'.$service[0].'')){
            return $border->responseOut([],'project has not been created');
        }

        define("app",$service[0]);
        if(array_key_exists(1,$service)){ define("service",$service[1]);} else{ $service[1]=null;}

        define("version",$getVersion);
        define("method",$serviceMethod);
        define("request",$_SERVER['REQUEST_METHOD']);

        //get preloader classes
        $border->getPreLoaderClasses();

        //check package auto service and method
        if($border->checkPackageAuto($service)['status']){
            $packageAuto=$border->resolve->resolve($border->checkPackageAuto($service)['class']);
            return $border->responseOut($packageAuto->$serviceMethod());
        }

        //check package dev service and method
        if($border->checkPackageDev($service)['status']){
            $packageDev=$border->resolve->resolve($border->checkPackageDev($service)['class']);
            define("devPackage",true);
            return $border->responseOut($packageDev->$serviceMethod());
        }

        if(!file_exists(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'')){
            return $border->responseOut([],'service has not been created');
        }

        if(!file_exists(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php')){
            return $border->responseOut([],'service has not been created');
        }

        //get before middleware
        $border->middleware("before");

        //token run
        return $border->token(function() use ($service,$serviceMethod,$getVersion,$border) {

            //provision run
            return $border->provision(function() use ($service,$serviceMethod,$getVersion,$border) {

                //service main file extends this file
                require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php');

                //service main file
                //require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/index.php');

                //apix resolve
                $apix=$border->resolve->resolve("\\src\\app\\".$service[0]."\\".$getVersion."\\__call\\".$service[1]."\\".request."Service");

                $requestServiceMethod=$serviceMethod;

                if(method_exists($apix,$requestServiceMethod)){
                    //call service
                    return $border->responseOut($apix->$requestServiceMethod());
                }
                else{

                    return $border->responseOut([],'service is invalid');
                }
            });
        });



    }

    /**
     * get request uri.
     *
     * this checks request uri parameter.
     *
     * @param string
     * @return request uri runner
     */

    private function requestUri(){

        return $_SERVER['REQUEST_URI'];
    }

    /**
     * get directory name.
     *
     * directory name
     *
     * @param string
     * @return directory name runner
     */

    private function getDirectoryName(){

        $root=explode("/",root);
        return end($root);
    }


    /**
     * compare with root to request uri.
     *
     * compare request uri
     *
     * @param string
     * @return request uri compare runner
     */

    private function getServiceNameAndMethodFromRequestUri(){

        $service=str_replace("/".$this->getDirectoryName()."/service/","",$this->requestUri());
        return explode("/",$service);
    }


    /**
     * get pure method from service
     *
     * pure method name
     *
     * @param string
     * @return pure method runner
     */

    private function getPureMethodNameFromService(){

        $service=$this->getServiceNameAndMethodFromRequestUri();
        return preg_replace('@\?(.*)@is','',end($service));
    }


    /**
     * get query params
     *
     * query params
     *
     * @param string
     * @return query params runner
     */

    private function getQueryParamsFromRoute(){

        $service=$this->getServiceNameAndMethodFromRequestUri();
        $params=preg_replace('@'.$this->getPureMethodNameFromService().'\?@is','',end($service));

        if($params==$this->getPureMethodNameFromService()) {
            return [];
        }
        else {

            $getParams=explode("&",$params);
            $paramlist=[];
            foreach ($getParams as $main){
                $getParamsMain=explode("=",$main);
                $paramlist[$getParamsMain[0]]=$getParamsMain[1];
            }

            return $paramlist;
        }
    }


    /**
     * get config version number
     *
     * version number
     *
     * @param string
     * @return get config version runner
     */

    private function getConfigVersionNumber(array $data){
        if(file_exists(root.'/src/app/'.$data['serviceName'].'/version.php')){
            $version=require_once(root.'/src/app/'.$data['serviceName'].'/version.php');
            if(is_array($version) && array_key_exists("version",$version)) {
                return $version['version'];
            }
            return 'v1';
        }

    }

    /**
     * response out.
     *
     * outputs last data.
     *
     * @param string
     * @return response out runner
     */

    private function responseOut($data,$msg=null){

        $queryError=[];
        if(!is_array($data)){
            $data=[$data];
        }
        if(array_key_exists("queryResult",$data)){
            if(is_array($data['queryResult']) && array_key_exists("error",$data['queryResult'])){
                if($data['queryResult']['error']){
                    $queryError=['success'=>(bool)false]+['error'=>$data['queryResult']];
                }
            }
        }
        header('Content-Type: application/json');
        if(is_array($data) && count($data)){

            if(\config::get("objectloader")!==null && \config::get("objectloader")){

                //object loader
                $data=['success'=>(bool)true]+['data'=>$data+self::objectLoaderMethodCall()];
            }
            else{
                //default
                $data=['success'=>(bool)true]+['data'=>$data];
            }

        }
        else{
            $msg=($msg!==null) ? $msg : 'data is not array';

            $data=['success'=>(bool)false]+['message'=>$msg];
        }

        if(count($queryError)){
            return json_encode($queryError);
        }
        return json_encode($data);

    }


    /**
     * get preloader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    private function middleware($prefix){

        $Middleware="\\src\\middleware\\".$prefix."Middleware";
        $Middleware=new $Middleware([]);

        $app=''.app.'/'.service.'/'.method;

        if(!in_array($app,$Middleware->except())){
            return $Middleware->handle();
        }



    }


    /**
     * get object loader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    private function objectLoaderMethodCall(){

        $border=self::$_instance;

        $objectLoader="\\src\\provisions\\objectloader";
        $objectLoader=$border->resolve->resolve($objectLoader);
        $objectLoaderMethod=request.'ObjectLoader';

        $objectLoaderExcept=strtolower(request).'Except';

        $objectMethodicCall=$objectLoader->$objectLoaderMethod();

        $exceptapp=app.'/'.service;

        if(in_array($exceptapp,$objectLoader->$objectLoaderExcept())){

            $objectMethodicCall=[];
        }


        $serviceobjectLoader="\\src\\app\\".app."\\v1\\provisions\\objectloader";
        $serviceobjectLoader=$border->resolve->resolve($serviceobjectLoader);
        $serviceobjectLoaderMethod=request.'ObjectLoader';

        $servicemethodicCall=$serviceobjectLoader->$serviceobjectLoaderMethod();
        $s_serviceobjectLoaderMethodExcept=strtolower(request).'Except';

        if(in_array(service,$serviceobjectLoader->$s_serviceobjectLoaderMethodExcept())){

            $servicemethodicCall=[];
        }


        //individual method like getStk()
        $s_serviceobjectLoader="\\src\\app\\".app."\\v1\\provisions\\objectloader";
        $s_serviceobjectLoader=$border->resolve->resolve($s_serviceobjectLoader);
        $s_serviceobjectLoaderMethod=strtolower(request).''.ucfirst(service);





        $s_serviceobjectLoaderMethodcall=[];
        if(method_exists($s_serviceobjectLoader,$s_serviceobjectLoaderMethod)){
            $s_serviceobjectLoaderMethodcall=$s_serviceobjectLoader->$s_serviceobjectLoaderMethod();
        }

        return array_merge_recursive($servicemethodicCall,$s_serviceobjectLoaderMethodcall,$objectMethodicCall);
    }


    /**
     * get preloader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    private function checkPackageAuto($service){

        if(file_exists(root."/src/packages/auto/".$service[1]."/".$service[1].".php")){
            return [
                'status'=>true,
                'class'=>"\\src\\packages\\auto\\".$service[1]."\\".$service[1]
            ];
        }
        return [
            'status'=>false
        ];
    }



    /**
     * get preloader dev classes.
     *
     * outputs project package dev.
     *
     * @param string
     * @return response package dev runner
     */

    private function checkPackageDev($service){

        if(file_exists(root."/src/packages/dev/".$service[1]."/".request."Service.php")){
            return [
                'status'=>true,
                'class'=>"\\src\\packages\\dev\\".$service[1]."\\".strtolower(request)."Service"
            ];
        }
        return [
            'status'=>false
        ];
    }



    /**
     * get token classes.
     *
     * outputs token.
     *
     * @param string
     * @return response token runner
     */

    private function token($callback){

        //get token
        $token="\\src\\provisions\\token";
        $token=$this->resolve->resolve($token);
        $tokenhandle=$token->handle();
        $tokenexcept=$token->except();

        if(!$tokenhandle['status']){

            //return token provision
            return call_user_func($callback);
        }

        $queryParams=$this->getQueryParamsFromRoute();

        //token provision
        if(array_key_exists("_token",$queryParams)){

            if(in_array($queryParams['_token'],$tokenhandle['tokens'])){

                if(!array_key_exists($queryParams['_token'],$tokenhandle['clientIp'])){
                    //return token provision
                    return call_user_func($callback);
                }

                if($tokenhandle['clientIp'][$queryParams['_token']]==$_SERVER['REMOTE_ADDR']){

                    //return token provision
                    return call_user_func($callback);
                }

            }
        }

        //except provision
        if(in_array(app.'/'.service.'/'.method.'',$tokenexcept) OR in_array(app.'/'.service.'',$tokenexcept)){
            //return token provision
            return call_user_func($callback);
        }

        //except provision clientIp
        if(array_key_exists($_SERVER['REMOTE_ADDR'],$tokenexcept['clientIp'])){
            if(in_array(app.'/'.service.'/'.method.'',$tokenexcept['clientIp'][$_SERVER['REMOTE_ADDR']]) OR in_array(app.'/'.service.'',$tokenexcept['clientIp'][$_SERVER['REMOTE_ADDR']])){
                //return token provision
                return call_user_func($callback);
            }
        }

        //return token provision false
        return $this->responseOut([],'token provision error');



    }


    /**
     * get provision classes.
     *
     * outputs provision.
     *
     * @param string
     * @return response class_alias runner
     */

    private function provision($callback){

        $provision="\\src\\provisions\\index";
        $provision=$this->resolve->resolve($provision);
        $provisionMethod=''.request.'Provision';
        $provisionMethodExcept=''.request.'Except';

        if($provision->$provisionMethod()['success'] OR in_array(app.'/'.service.'',$provision->$provisionMethodExcept())){

            $serviceprovision="\\src\\app\\".app."\\v1\\provisions\\index";
            $serviceprovision=$this->resolve->resolve($serviceprovision);
            $serviceprovisionMethod=''.request.'Provision';
            $serviceprovisionExcept=''.request.'Except';

            if($serviceprovision->$serviceprovisionMethod()['success'] OR in_array(service,$serviceprovision->$serviceprovisionExcept())){

                return call_user_func($callback);
            }


        }

        return $this->responseOut([],$provision->$provisionMethod()['message']);

    }


    /**
     * get preloader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    private function getPreLoaderClasses(){

        class_alias("\\src\\services\\session","session");
        class_alias("\\src\\config\\app","app");
        class_alias("\\src\\config\\config","config");
        class_alias("\\src\\services\\branches","branch");
        class_alias("\\lib\\appContainer","container");

        return;

    }



}