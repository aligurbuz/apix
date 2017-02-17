<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class command {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //project create command
    public function create ($data){


        foreach ($data as $key=>$value){
            $file=$key;
        }

        //usage api command create file:file
        $list=[];
        $touchServiceCommandMe['execution']='command';
        $touchServiceCommandMe['params']['class']=$file;
        $list[]=$this->touch(''.$file.'.php',$touchServiceCommandMe);


        return $this->fileProcessResult($list,function(){
            return 'command has been created';
        });

        return 'command fail';

    }


    //set mkdir
    public function mkdir($data){

        return $this->fileprocess->mkdir($data);
    }

    //set mkdir
    public function touch($data,$param){

        return $this->fileprocess->command($data,$param);
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