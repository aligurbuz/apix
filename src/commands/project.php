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
    }


    //project create command
    public function create ($data){

        $list=[];
        if($this->mkdir($this->getProjectName($data))){

            $list[]=$this->mkdir($this->getProjectName($data).'/docs');
            $list[]=$this->touch($this->getProjectName($data).'/docs/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1');
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/staticProvider');
            $list[]=$this->touch($this->getProjectName($data).'/v1/staticProvider/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/__call');
            $list[]=$this->touch($this->getProjectName($data).'/v1/__call/index.html',null);
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/config');
            $list[]=$this->mkdir($this->getProjectName($data).'/v1/config/database');
            $list[]=$this->touch($this->getProjectName($data).'/v1/config/database/index.html',null);
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
        $fd=require ('./src/commands/lib/filedirprocess.php');
        return new filedirprocess();

    }
}