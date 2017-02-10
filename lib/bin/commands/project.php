<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class project {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //project create command
    public function create ($data){

        $list=[];
        if($this->mkdir($this->getProjectName($data))){

            $touchServiceReadMe['execution']='project_readme';
            $touchServiceReadMe['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/README.md',$touchServiceReadMe);

            $touchServiceVersionMe['execution']='project_version';
            $touchServiceVersionMe['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/version.php',$touchServiceVersionMe);

            $touchServicePublishMe['execution']='project_publish';
            $touchServicePublishMe['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/publish.php',$touchServicePublishMe);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage');
            $list[]=$this->touch($this->getProjectName($data).'/storage/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage/lang');
            $list[]=$this->touch($this->getProjectName($data).'/storage/lang/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage/env');
            $list[]=$this->touch($this->getProjectName($data).'/storage/env/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/docs');
            $list[]=$this->touch($this->getProjectName($data).'/docs/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1');


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/webServices');
            $list[]=$this->touch($this->getProjectName($data).'/v1/webServices/index.html',null);

            $touchServiceBaseControllerParams['execution']='serviceBaseController';
            $touchServiceBaseControllerParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/serviceBaseController.php',$touchServiceBaseControllerParams);

            $touchServiceReadyControllerParams['execution']='serviceReadyController';
            $touchServiceReadyControllerParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/serviceReadyController.php',$touchServiceReadyControllerParams);

            $serviceLogController['execution']='serviceLogController';
            $serviceLogController['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/serviceLogController.php',$serviceLogController);

            $servicePackageDevController['execution']='servicePackageDevController';
            $servicePackageDevController['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/servicePackageDevController.php',$servicePackageDevController);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/staticProvider');
            $list[]=$this->touch($this->getProjectName($data).'/v1/staticProvider/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/__call');
            $list[]=$this->touch($this->getProjectName($data).'/v1/__call/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/config');


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/provisions');

            $touchprovisionindex['execution']='services/provision';
            $touchprovisionindex['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/provisions/index.php',$touchprovisionindex);

            $touchprovisionobjectloader['execution']='services/objectloader';
            $touchprovisionobjectloader['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/provisions/objectloader.php',$touchprovisionobjectloader);


            $touchServiceApp['execution']='app';
            $touchServiceApp['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/app.php',$touchServiceApp);

            $database['execution']='services/database';
            $database['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/database.php',$database);


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/platform');
            $list[]=$this->touch($this->getProjectName($data).'/v1/platform/index.html',null);

            $platformServiceConfParams['execution']='services/platform_config';
            $platformServiceConfParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/platform/config.php',$platformServiceConfParams);

            $database['execution']='services/rabbitMQ';
            $database['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/rabbitMQ.php',$database);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/migrations');
            $list[]=$this->touch($this->getProjectName($data).'/v1/migrations/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/index.html',null);

            return $this->fileProcessResult($list,function(){
                return 'project has been created';
            });
        }

        return 'project fail';

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

            return 'project fail';
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