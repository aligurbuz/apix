<?php namespace lib\bin\commands;
use lib\staticPathModel;
use lib\utils;

/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class job {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        //require("./lib/bin/commands/lib/getenv.php");
    }


    //project create command
    public function create ($data){

        //using php api job create queue:rabbitmq|queuename project_name:file

        $dirQueue=$data['queue'];
        $list=[];

        foreach ($data as $key=>$value){
            if($key!=="queue"){
                $project=$key;
                $dir=$value;
            }
        }

        $appOptionalJobDir=staticPathModel::getProjectPath($project).'/'.utils::getAppVersion($project).'/optional/jobs';
        $rabbitMqPath=$appOptionalJobDir.'/rabbitmq';
        if(!file_exists($rabbitMqPath)){
            $list[]=$this->mkdir($rabbitMqPath);
        }


        if(!file_exists($rabbitMqPath.'/'.$dir)){

            $list[]=$this->mkdir($rabbitMqPath.'/'.$dir);

            $touchServiceRabbitMqPublisher['execution']='rabbitMq_publisher';
            $touchServiceRabbitMqPublisher['params']['projectName']=$project;
            $touchServiceRabbitMqPublisher['params']['version']=utils::getAppVersion($project);
            $touchServiceRabbitMqPublisher['params']['dir']=$dir;
            $list[]=$this->touch($rabbitMqPath.'/'.$dir.'/publisher.php',$touchServiceRabbitMqPublisher);

            $touchServiceRabbitMqSubscriber['execution']='rabbitMq_subscriber';
            $touchServiceRabbitMqSubscriber['params']['projectName']=$project;
            $touchServiceRabbitMqSubscriber['params']['version']=utils::getAppVersion($project);
            $touchServiceRabbitMqSubscriber['params']['dir']=$dir;
            $list[]=$this->touch($rabbitMqPath.'/'.$dir.'/subscriber.php',$touchServiceRabbitMqSubscriber);


            return $this->fileProcessResult($list,function(){
                return 'job has been created';
            });
        }
        else{
            return 'job fail';
        }


    }


    //project create command
    public function pusher ($data){
        $list=array_keys($data);
        $path=utils::getAppRootNamespace($list[1]).'\\optional\\jobs\\'.$list[0].'\\'.$list[2].'\\'.$list[3];
        return new $path($list[1],$list[2]);
    }


    //set mkdir
    public function mkdir($data){

        return $this->fileprocess->mkdir_path($data);
    }



    //set mkdir
    public function touch($data,$param){

        return $this->fileprocess->touch_path($data,$param);
    }

    //mkdir process result
    public function fileProcessResult($data,$callback){

        if(count($data)==0 OR in_array(false,$data)){

            return 'job fail';
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