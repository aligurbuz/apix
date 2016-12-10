<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */

class project {


    //project create command
    public function create ($data){

        //new file process
        $fileprocess=$this->fileprocess();

        //file process mkdir
        if($fileprocess->mkdir($this->getProjectName($data))){
            if($fileprocess->mkdir($this->getProjectName($data).'/v1')){
                if($fileprocess->mkdir($this->getProjectName($data).'/v1/staticProvider')){

                    //return static provider true
                    return 'project has been created';
                }
                else {

                    //return static provider false
                    return 'error :static provider fail';
                }


            }
            else{

                //return version false
                return 'error :version fail';
            }
        }
        else
        {
            //return project false
            return 'error:project fail';
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