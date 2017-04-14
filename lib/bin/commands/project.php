<?php namespace lib\bin\commands;
use Lib\Console;
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class project extends console {

    public $fileprocess;

    public function __construct(){
        parent::__construct();
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

            $list[]=$this->mkdir($this->getProjectName($data).'/declaration');
            $list[]=$this->touch($this->getProjectName($data).'/declaration/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/declaration/history');
            $list[]=$this->touch($this->getProjectName($data).'/declaration/history/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage');
            $list[]=$this->touch($this->getProjectName($data).'/storage/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage/lang');
            $list[]=$this->touch($this->getProjectName($data).'/storage/lang/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage/session');
            $list[]=$this->touch($this->getProjectName($data).'/storage/session/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage/logs');
            $list[]=$this->touch($this->getProjectName($data).'/storage/logs/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/storage/env');
            $list[]=$this->touch($this->getProjectName($data).'/storage/env/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/composer');
            $list[]=$this->touch($this->getProjectName($data).'/composer/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1');

            $list[]=$this->touch($this->getProjectName($data).'/composer.json',null);

            $touchProjectComposer['execution']='project_composer';
            $touchProjectComposer['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/composer.json',$touchProjectComposer);

            $list[]=$this->touch($this->getProjectName($data).'/.gitignore',null);

            $touchProjectGitignore['execution']='project_gitignore';
            $touchProjectGitignore['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/.gitignore',$touchProjectGitignore);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/optional');
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/index.html',null);


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/optional/webServices');
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/webServices/index.html',null);

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

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/optional/staticProvider');
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/staticProvider/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/__call');
            $list[]=$this->touch($this->getProjectName($data).'/v1/__call/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/config');

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/optional/repository');
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/repository/index.html',null);


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/optional/provisions');

            $touchprovisionindex['execution']='services/provision';
            $touchprovisionindex['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/provisions/index.php',$touchprovisionindex);

            $touchprovisionobjectloader['execution']='services/objectloader';
            $touchprovisionobjectloader['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/provisions/objectloader.php',$touchprovisionobjectloader);


            $touchServiceApp['execution']='app';
            $touchServiceApp['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/app.php',$touchServiceApp);

            $touchServiceSocialize['execution']='services/socialize';
            $touchServiceSocialize['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/socialize.php',$touchServiceSocialize);

            $database['execution']='services/database';
            $database['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/database.php',$database);


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/optional/platform');
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/platform/index.html',null);

            $platformServiceConfParams['execution']='services/platform_config';
            $platformServiceConfParams['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/optional/platform/config.php',$platformServiceConfParams);

            $database['execution']='services/rabbitMQ';
            $database['params']['projectName']=$this->getProjectName($data);
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/rabbitMQ.php',$database);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/migrations');
            $list[]=$this->touch($this->getProjectName($data).'/v1/migrations/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/migrations/schemas');
            $list[]=$this->touch($this->getProjectName($data).'/v1/migrations/schemas/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/migrations/seeds');
            $list[]=$this->touch($this->getProjectName($data).'/v1/migrations/seeds/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/index.html',null);


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model/sudb');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/sudb/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model/sudb/builder');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/sudb/builder/index.html',null);


            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model/eloquent');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/eloquent/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model/eloquent/builder');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/eloquent/builder/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model/doctrine');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/doctrine/index.html',null);

            $list[]=$this->mkdir($this->getProjectName($data).'/v1/model/doctrine/builder');
            $list[]=$this->touch($this->getProjectName($data).'/v1/model/doctrine/builder/index.html',null);

            return $this->fileProcessResult($list,function() use($data) {
                return $this->success('+++ the project named '.$this->getProjectName($data).' has been created succesfully...');
            });
        }

        return $this->error('project fail');

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
        $file=$libconf['libFile'];
        return new $file();

    }
}