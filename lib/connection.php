<?php

namespace lib;

class connection {

    public $container;
    public $resolve;
    
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
        $border=new self;
        
        //get preloader classes
        $border->getPreLoaderClasses();

        $border->resolve->resolve("\\lib\\appContainer")->get();

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

        define("app",$service[0]);
        define("service",$service[1]);
        define("version",$getVersion);
        define("method",$serviceMethod);

        //get before middleware
        $border->middleware("before");

        //service main file extends this file
        require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php');

        //service main file
        require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/index.php');


        //apix resolve
        $apix=$border->resolve->resolve("\\src\\app\\".$service[0]."\\".$getVersion."\\__call\\".$service[1]."\\index");


        //call service
        return $border->responseOut($apix->$serviceMethod());
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


        if(array_key_exists($data['serviceName'],\config::get("appVersions")))
        {
            return \config::get("appVersions")[$data['serviceName']];
        }
        return 'v1';
    }

    /**
     * response out.
     *
     * outputs last data.
     *
     * @param string
     * @return response out runner
     */

    private function responseOut($data){

        header('Content-Type: application/json');
        if(is_array($data) && count($data)){
            $data=['success'=>(bool)true]+['data'=>$data];
            return json_encode($data);
        }
        else{
            $data=['success'=>(bool)false]+['message'=>'data is not array'];
            return json_encode($data);
        }

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
     * get preloader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    private function getPreLoaderClasses(){

        class_alias("\\src\\config\\app","app");
        class_alias("\\src\\config\\config","config");
        class_alias("\\src\\services\\branches","branch");
        return;

    }



}