<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class platform {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        //usage : api platform create project_name:service_name platform_dir:platform_file
        $paramdata=$this->getParams($data);
        foreach($paramdata[1] as $platform=>$file){
            $platformdir=$platform;
            $platformfile=$file;
        }

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){
                foreach ($value as $project=>$service){
                    $version=require ('./src/app/'.$project.'/version.php');
                    $version=(is_array($version) && array_key_exists('version',$version)) ? $version['version'] : 'v1';
                    $list=[];
                    $platformServiceGetParams['execution']='services/platform';
                    $platformServiceGetParams['params']['projectName']=$project;
                    $platformServiceGetParams['params']['serviceName']=$service;
                    $platformServiceGetParams['params']['platformdir']=$platformdir;
                    $platformServiceGetParams['params']['platformfile']=$platformfile;
                    $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/platform/'.$platformdir.'/'.$platformfile.'.php',$platformServiceGetParams);


                    return $this->fileProcessResult($list,function(){
                        return 'platform file has been created';
                    });

                    return 'platform fail';
                }
            }
        }

    }

    //usage : api service publish project:service names:method1/method2 http:get|post


    //get bin params
    public function getParams($data){
        $params=[];
        foreach ($data as $key=>$value){

            $params[]=[$key=>$value];

        }

        return $params;
    }


    //set mkdir
    public function mkdir($data){

        return $this->fileprocess->mkdir($data);
    }

    //set mkdir
    public function touch($data,$param){

        return $this->fileprocess->touch($data,$param);
    }

    //mkdir process result
    public function fileProcessResult($data,$callback){

        if(count($data)==0 OR in_array(false,$data)){

            return 'service fail';
        }
        else {

            return call_user_func($callback);
        }

    }

    //get project name
    public function getProjectName($data){

        //get project name
        foreach ($data as $key=>$value){
            return $key;
        }
    }

    //file process
    public  function fileprocess(){

        //file process new instance
        $libconf=require("./lib/bin/commands/lib/conf.php");
        $fd=require ($libconf['libFile']);
        return new filedirprocess();

    }

}