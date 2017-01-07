<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class branch {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
    }


    //service create command
    public function source ($data){

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){
                foreach ($value as $project=>$service){
                    $version=require ('./src/app/'.$project.'/version.php');
                    $version=(is_array($version) && array_key_exists('version',$version)) ? $version['version'] : 'v1';

                    $list=[];

                    $sourceParams['execution']='services/branch_source';
                    $sourceParams['params']['projectName']=$project;
                    $sourceParams['params']['serviceName']=$service;
                    $sourceParams['params']['className']=$this->getParams($data)[1]['file'];
                    $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/branches/source/'.$this->getParams($data)[1]['file'].'.php',$sourceParams);

                    return $this->fileProcessResult($list,function(){
                        return 'branch source new file has been created';
                    });
                }
            }
        }

    }


    //service create command
    public function query ($data){



        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){
                require ('./src/config/config.php');
                $config=\src\config\config::get("appVersions");
                foreach ($value as $project=>$service){
                    $version=(array_key_exists($project,$config)) ? $config[$project] : 'v1';
                    $list=[];

                    $sourceParams['execution']='services/branch_query';
                    $sourceParams['params']['projectName']=$project;
                    $sourceParams['params']['serviceName']=$service;
                    $sourceParams['params']['className']=$this->getParams($data)[1]['file'];
                    $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/branches/query/'.$this->getParams($data)[1]['file'].'.php',$sourceParams);

                    return $this->fileProcessResult($list,function(){
                        return 'branch query new file has been created';
                    });
                }
            }
        }

    }


    //service create command
    public function handle ($data){

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){
                require ('./src/config/config.php');
                $config=\src\config\config::get("appVersions");
                foreach ($value as $project=>$service){
                    $version=(array_key_exists($project,$config)) ? $config[$project] : 'v1';
                    $list=[];

                    $sourceParams['execution']='services/branch_handle';
                    $sourceParams['params']['projectName']=$project;
                    $sourceParams['params']['serviceName']=$service;
                    $sourceParams['params']['className']=$this->getParams($data)[1]['file'];
                    $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/branches/handle/'.$this->getParams($data)[1]['file'].'.php',$sourceParams);

                    return $this->fileProcessResult($list,function(){
                        return 'branch handle new file has been created';
                    });
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
        $fd=require ('./src/commands/lib/filedirprocess.php');
        return new filedirprocess();

    }

}