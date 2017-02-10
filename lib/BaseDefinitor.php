<?php
/*
 * This file is main class of the  service named stk on  mobi project .
 * METHOD : GET
 * every service is called with index method as default
 * service name : mobi
 * namespace : src\app\mobi\v1\__call\stk
 * app class namespace : \src\app\mobi\v1\__call\stk\app
 */

namespace lib;
use Symfony\Component\Yaml\Yaml;

/**
 * Represents a getService class.
 *
 * main call
 * return type array
 */

class BaseDefinitor  {

    public $request;
    protected $projectPath='src/app';

    /**
     * get file classes.
     *
     * outputs get file.
     *
     * @param string
     * @return response file runner
     */

    protected function getFileClassRequire($data){
        return require($data);
    }

    /**
     * get version classes.
     *
     * outputs get version.
     *
     * @param string
     * @return response version runner
     */

    protected function getProjectVersioning($data){
        return root.'/'.$this->projectPath.'/'.$data['serviceName'].'/version.php';
    }

    /**
     * get preloader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    protected function getPreLoaderClasses(){
        $serviceConfig="\\src\\app\\".app."\\".version."\\config\\app";
        $serviceConfig=new $serviceConfig();
        $staticProvider=$serviceConfig->staticProvider();
        foreach($staticProvider as $key=>$value){
            $namespace="\\src\\app\\".app."\\".version."\\staticProvider\\".$key."";
            if($value=="all"){
                class_alias($namespace,$key);
            }
            else{
                if(in_array(service,$value)){
                    class_alias($namespace,$key);
                }
            }
        }
        return $this->getFileClassRequire(root.'/lib/appClassAlias.php');

    }

    /**
     * get resolve classes.
     *
     * outputs class resolver.
     *
     * @param string
     * @return response resolve runner
     */

    protected function getClassDependencyResolver(){
        $resolve=$this->getFileClassRequire(root.'/lib/resolver.php');
        return new \classresolver();

    }



    /**
     * get serviceDump classes.
     *
     * it dumps service objects and service requirements.
     *
     * @param serviceDump
     * @return response serviceDump runner
     */
    protected function serviceDump($requestServiceMethodReal=null,$requestServiceMethod=null,$other=array()){
        return $this->serviceConf(function() use ($requestServiceMethodReal,$requestServiceMethod,$other){
            return new serviceDumpObjects($requestServiceMethodReal,$requestServiceMethod,$other);
        });


    }

    /**
     * get serviceconf classes.
     *
     * outputs class resolver.
     *
     * @param string
     * @return response serviceConf runner
     */
    protected function serviceConf($callback=null){
        $serviceConfFile=root."/".src."/".app."/".version."/__call/".service."/serviceConf.php";
        $serviceConf=require($serviceConfFile);
        if($callback==null){
            return $serviceConf;
        }

        if(is_callable($callback)){
            if(is_array($serviceConf) && array_key_exists("dataDump",$serviceConf) && $serviceConf['dataDump']){
                return call_user_func($callback);
            }
        }

        return [];

    }


    /**
     * get definition classes.
     *
     * outputs class definition.
     *
     * @param string
     * @return response definition runner
     */

    protected function getAppDefinitionLoader(){
        $appDefinition=\src\config\app::getAppDefinition();
        $userappDefinitionClass="\\src\\app\\".app."\\".version."\\config\\app";
        $userappDefinition=$userappDefinitionClass::getAppDefinition();
        $appDefinition=$appDefinition+$userappDefinition;
        if(count($appDefinition)){
            foreach($appDefinition as $key=>$value){
                define($key,$value);
            }
        }

    }

    /**
     * get directory name.
     *
     * directory name
     *
     * @param string
     * @return directory name runner
     */
    protected function getDirectoryName(){
        $root=explode("/",root);
        return end($root);
    }

    /**
     * get request uri.
     *
     * this checks request uri parameter.
     *
     * @param string
     * @return request uri runner
     */

    protected function requestUri(){
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * compare with root to request uri.
     *
     * compare request uri
     *
     * @param string
     * @return request uri compare runner
     */
    protected function getServiceNameAndMethodFromRequestUri(){
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
    protected function getPureMethodNameFromService(){
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

    protected function getQueryParamsFromRoute(){

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
                if(count($getParamsMain)>0 && array_key_exists(1,$getParamsMain))
                {
                    $paramlist[$getParamsMain[0]]=$getParamsMain[1];
                }

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
    protected function getConfigVersionNumber(array $data){
        $getVersionFile=$this->getProjectVersioning($data);
        if(file_exists($getVersionFile)){
            $version=$this->getFileClassRequire($getVersionFile);
            if(is_array($version) && array_key_exists("version",$version)) {
                return $version['version'];
            }
            return 'v1';
        }
    }


    /**
     * get logging.
     *
     * this checks data uri parameter.
     *
     * @param string
     * @return request logging runner
     */

    protected function logging($data,$callback){
        //this fake
        $instance=$this;
        if(array_key_exists("token",$this->getQueryParamsFromRoute())){
            $token=$this->getQueryParamsFromRoute()['token'];
        }
        else{
            $token=null;
        }
        $logdata=[
            'project'=>app,
            'version'=>version,
            'service'=>service,
            'method'=>method,
            'http'=>request,
            'token'=>$token,
            'data'=>$data
        ];
        $log="\\src\\app\\".app."\\".version."\\serviceLogController";
        $log=$instance->resolve->resolve($log);
        if(property_exists($log,"status") && !$log->status){
            return call_user_func($callback);
        }
        else{
            if($log->handle($logdata)){
                return call_user_func($callback);
            }
            return $instance->responseOut([],'logging false');
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

    protected function middleware($prefix){

        $Middleware="\\src\\middleware\\".$prefix."Middleware";
        $Middleware=new $Middleware([]);

        $app=''.app.'/'.service.'/'.method;
        if(!in_array($app,$Middleware->except())){
            return $Middleware->handle();
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

    protected function responseOut($data,$msg=null){
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
        $developer=[];
        if(defined("app") && defined("version") && defined("service")){
            $developerfile=root.'/src/app/'.app.'/'.version.'/__call/'.service.'/developer.php';
            if(file_exists($developerfile)){
                $developer=require($developerfile);
            }

        }

        $developInfo=null;
        if(is_array($developer) && count($developer)){
            $developInfo=$developer;
        }
        if(is_array($data) && count($data)){
            if(\config::get("objectloader")!==null && \config::get("objectloader")){
                //object loader
                $data=['success'=>(bool)true,'statusCode'=>200,
                        'responseTime'=>microtime(true)-time_start,
                        'requestDate'=>date("Y-m-d H:i:s")]+['data'=>$data+self::objectLoaderMethodCall(),'development'=>$developInfo];
            }
            else{
                //default
                $data=['success'=>(bool)true,'statusCode'=>200,'responseTime'=>microtime(true)-time_start,
                        'requestDate'=>date("Y-m-d H:i:s")]+['data'=>$data,'development'=>$developInfo,];
            }
        }
        else{
            $msg=($msg!==null) ? $msg : 'data is empty';
            $data=['success'=>(bool)false,'statusCode'=>204,'responseTime'=>microtime(true)-time_start,
                    'requestDate'=>date("Y-m-d H:i:s")]+['message'=>$msg,'development'=>$developInfo,];
        }

        if(count($queryError)){
            return json_encode($queryError);
        }
        return json_encode($data);

    }

    /**
     * get object loader classes.
     *
     * outputs class_alias.
     *
     * @param string
     * @return response class_alias runner
     */

    protected function objectLoaderMethodCall(){

        $instance=$this;

        $objectLoader="\\src\\provisions\\objectloader";
        $objectLoader=$instance->resolve->resolve($objectLoader);
        $objectLoaderMethod=request.'ObjectLoader';

        $objectLoaderExcept=strtolower(request).'Except';

        $objectMethodicCall=$objectLoader->$objectLoaderMethod();

        $exceptapp=app.'/'.service;

        if(in_array($exceptapp,$objectLoader->$objectLoaderExcept())){

            $objectMethodicCall=[];
        }

        $serviceobjectLoader="\\src\\app\\".app."\\v1\\provisions\\objectloader";
        $serviceobjectLoader=$instance->resolve->resolve($serviceobjectLoader);
        $serviceobjectLoaderMethod=request.'ObjectLoader';

        $servicemethodicCall=$serviceobjectLoader->$serviceobjectLoaderMethod();
        $s_serviceobjectLoaderMethodExcept=strtolower(request).'Except';

        if(in_array(service,$serviceobjectLoader->$s_serviceobjectLoaderMethodExcept())){

            $servicemethodicCall=[];
        }

        //individual method like getStk()
        $s_serviceobjectLoader="\\src\\app\\".app."\\v1\\provisions\\objectloader";
        $s_serviceobjectLoader=$instance->resolve->resolve($s_serviceobjectLoader);
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

    protected function checkPackageAuto($service){
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

    protected function checkPackageDev($service){

        $servicePackageDev=require(root.'/src/app/'.app.'/'.version.'/servicePackageDevController.php');
        if(is_array($servicePackageDev))
        {
            if(!in_array($service[1],$servicePackageDev['packageDevSource']['package'])){
                $service[1]=null;
            }
        }
        if(file_exists(root."/src/packages/dev/".$service[1]."/".request."Service.php")){
            $definitions=(array_key_exists($service[1],$servicePackageDev['packageDevSource']['packageDefinition'])) ? $servicePackageDev['packageDevSource']['packageDefinition'][$service[1]] : null;
            return [
                'status'=>true,
                'definitions'=>$definitions,
                'class'=>"\\src\\packages\\dev\\".$service[1]."\\".strtolower(request)."Service",
                'service'=>$service[1]
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

    protected function token($callback){
        //get token
        $token="\\src\\provisions\\token";
        $token=$this->resolve->resolve($token);

        $prodDumpStatus=false;
        if(is_callable($callback)){
            $tokenhandle=$token->handle(\lib\environment::get());
        }
        else{
            $tokenhandle=$token->handle("production");
            $this->serviceDump(null,null,['token'=>$tokenhandle['status']]);
            $prodDumpStatus=true;
        }

        //return token provision false
        if(false===$prodDumpStatus){
            $this->token("production");
        }

        $tokenexcept=$token->except();

        if(!$tokenhandle['status']){
            //return token provision
            if(is_callable($callback)){
                return call_user_func($callback);
            }

        }
        $queryParams=$this->getQueryParamsFromRoute();

        //token provision
        if(array_key_exists("_token",$queryParams)){

            if(in_array($queryParams['_token'],$tokenhandle['tokens'])){
                if(!array_key_exists($queryParams['_token'],$tokenhandle['clientIp'])){
                    //return token provision
                    if(is_callable($callback)){
                        return call_user_func($callback);
                    }

                }
                if(array_key_exists($queryParams['_token'],$tokenhandle['clientIp']) && $tokenhandle['clientIp'][$queryParams['_token']]==$_SERVER['REMOTE_ADDR']){
                    //return token provision
                    if(is_callable($callback)){
                        return call_user_func($callback);
                    }
                }

            }
        }

        //except provision
        if(in_array(app.'/'.service.'/'.method.'',$tokenexcept) OR in_array(app.'/'.service.'',$tokenexcept)){
            //return token provision
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }

        //except provision clientIp
        if(array_key_exists($_SERVER['REMOTE_ADDR'],$tokenexcept['clientIp'])){
            if(in_array(app.'/'.service.'/'.method.'',$tokenexcept['clientIp'][$_SERVER['REMOTE_ADDR']]) OR in_array(app.'/'.service.'',$tokenexcept['clientIp'][$_SERVER['REMOTE_ADDR']])){
                //return token provision
                if(is_callable($callback)){
                    return call_user_func($callback);
                }
            }
        }

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

    protected function provision($callback){

        $provision="\\src\\provisions\\index";
        $provision=$this->resolve->resolve($provision);
        $provisionMethod=''.request.'Provision';
        $provisionMethodExcept=''.request.'Except';

        $apl=$provision->$provisionMethod();


        if($apl['success'] OR in_array(app.'/'.service.'',$provision->$provisionMethodExcept())){

            if(!file_exists("./src/app/".app."/".version."/provisions/index.php")){
                return $this->responseOut([],"project or versioning is not valid");
            }
            $serviceprovision="\\src\\app\\".app."\\".version."\\provisions\\index";
            $serviceprovision=$this->resolve->resolve($serviceprovision);
            $serviceprovisionMethod=''.request.'Provision';
            $serviceprovisionExcept=''.request.'Except';
            $spl=$serviceprovision->$serviceprovisionMethod();
            if($spl['success'] OR in_array(service,$serviceprovision->$serviceprovisionExcept())){
                return call_user_func($callback);
            }
            else{
                $message=$spl['message'];
            }
        }
        else{
            $message=$apl['message'];
        }

        return $this->responseOut([],$message);

    }

    /**
     * get file fix log params.
     *
     * outputs get file.
     *
     * @param string
     * @return response fix log params runner
     */

    protected function getFixLog($data){
        $fixLog=$this->getFileClassRequire(root.'/lib/fixlogparams.php');
        return $fixLog[$data];
    }


    /**
     * get file boot params.
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */

    protected function bootServiceLoader($serviceMethod){
        return new appBootLoader($serviceMethod);
    }


}