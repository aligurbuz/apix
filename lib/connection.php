<?php

namespace lib;

class connection {

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

        //service main file extends this file
        require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/app.php');

        //service main file
        require(root . '/'.src.'/'.$service[0].'/'.$getVersion.'/__call/'.$service[1].'/index.php');

        //resolve process
        $resolve=require(root.'/lib/resolver.php');
        $resolve=new \classresolver();

        //apix resolve
        $apix=$resolve->resolve("\\src\\app\\".$service[0]."\\".$getVersion."\\__call\\".$service[1]."\\index");

        //get environment
        $border->getEnvironment();

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

        if(array_key_exists($data['serviceName'],\src\config\config::get("appVersions")))
        {
            return \src\config\config::get("appVersions")[$data['serviceName']];
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
        return json_encode($data);
    }

    /**
     * response environment.
     *
     * outputs environment.
     *
     * @param string
     * @return response environment runner
     */

    private function getEnvironment(){

        $envpath=root.'/env.php';

        if(file_exists($envpath)){
            return define('env','local');
        }else{
            return define('env','production');
        }

    }
}