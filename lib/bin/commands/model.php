<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class model {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){

                foreach ($value as $project=>$service){
                    $version=require ('./src/app/'.$project.'/version.php');
                    $version=(is_array($version) && array_key_exists('version',$version)) ? $version['version'] : 'v1';
                    $list=[];

                    $modelControlPath='./src/app/'.$project.'/'.$version.'/model/'.$this->getParams($data)[1]['file'].'.php';

                    if(!file_exists($modelControlPath)){
                        $modelParamsBuilder['execution']='services/modelBuilder';
                        $modelParamsBuilder['params']['projectName']=$project;
                        $modelParamsBuilder['params']['className']=$this->getParams($data)[1]['file'];
                        //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                        $list[]=$this->touch($project.'/'.$version.'/model/sudb/builder/'.$this->getParams($data)[1]['file'].'Builder.php',$modelParamsBuilder);

                        $modelParams['execution']='services/model';
                        $modelParams['params']['projectName']=$project;
                        $modelParams['params']['className']=$this->getParams($data)[1]['file'];
                        $modelParams['params']['tableName']=$this->getParams($data)[2]['table'];
                        $list[]=$this->touch($project.'/'.$version.'/model/sudb/'.$this->getParams($data)[1]['file'].'.php',$modelParams);


                        $modelParamsBuilder['execution']='services/eloquentmodelBuilder';
                        $modelParamsBuilder['params']['projectName']=$project;
                        $modelParamsBuilder['params']['className']=$this->getParams($data)[1]['file'];
                        //$modelParamsBuilder['params']['tableName']=$this->getParams($data)[2]['table'];
                        $list[]=$this->touch($project.'/'.$version.'/model/eloquent/builder/'.$this->getParams($data)[1]['file'].'Builder.php',$modelParamsBuilder);

                        $modelParams['execution']='services/eloquentmodel';
                        $modelParams['params']['projectName']=$project;
                        $modelParams['params']['className']=$this->getParams($data)[1]['file'];
                        $modelParams['params']['tableName']=$this->getParams($data)[2]['table'];
                        $list[]=$this->touch($project.'/'.$version.'/model/eloquent/'.$this->getParams($data)[1]['file'].'.php',$modelParams);

                        return $this->fileProcessResult($list,function(){
                            return 'model file has been created';
                        });
                    }

                    return $this->getParams($data)[1]['file'].' model is already available';


                }
            }
        }

    }




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