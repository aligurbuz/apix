<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class service {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
    }


    //service create command
    public function create ($data){

       foreach ($this->getParams($data) as $key=>$value){
           if($key==0){
               require ('./src/config/config.php');
               $config=\src\config\config::get("appVersions");
               foreach ($value as $project=>$service){
                   $version=(array_key_exists($project,$config)) ? $config[$project] : 'v1';
                   $list=[];
                   if($this->mkdir(''.$project.'/'.$version.'/__call/'.$service)){

                       $touchReadmeParams['execution']='project_readme';
                       $touchReadmeParams['params']['projectName']=$project;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/README.md',$touchReadmeParams);

                       $touchServiceParams['execution']='services/service';
                       $touchServiceParams['params']['projectName']=$project;
                       $touchServiceParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/index.php',$touchServiceParams);


                       $touchdeveloperParams['execution']='services/developer';
                       $touchdeveloperParams['params']['projectName']=$project;
                       $touchdeveloperParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/developer.php',$touchdeveloperParams);


                       $touchappParams['execution']='services/app';
                       $touchappParams['params']['projectName']=$project;
                       $touchappParams['params']['serviceName']=$service;
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/app.php',$touchappParams);


                       $list[]=$this->mkdir($project.'/v1/__call/'.$service.'/branches');
                       $list[]=$this->touch($project.'/v1/__call/'.$service.'/branches/index.html',null);
                       $list[]=$this->mkdir($project.'/v1/__call/'.$service.'/branches/handle');

                       $touchHandleParams['execution']='services/handle';
                       $touchHandleParams['params']['projectName']=$project;
                       $touchHandleParams['params']['serviceName']=$service;
                       $touchHandleParams['params']['handleName']='index';
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/branches/handle/index.php',$touchHandleParams);

                       $list[]=$this->mkdir($project.'/v1/__call/'.$service.'/branches/query');

                       $touchQueryParams['execution']='services/query';
                       $touchQueryParams['params']['projectName']=$project;
                       $touchQueryParams['params']['serviceName']=$service;
                       $touchQueryParams['params']['queryName']='index';
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/branches/query/index.php',$touchQueryParams);

                       $list[]=$this->mkdir($project.'/v1/__call/'.$service.'/branches/source');

                       $touchSourceParams['execution']='services/source';
                       $touchSourceParams['params']['projectName']=$project;
                       $touchSourceParams['params']['serviceName']=$service;
                       $touchSourceParams['params']['sourceName']='index';
                       $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/branches/source/index.php',$touchSourceParams);

                       return $this->fileProcessResult($list,function(){
                           return 'service has been created';
                       });

                   }

                   return 'service fail';
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