<?php
/**
 * File directory project.
 * type string
 * package:file process runner
 * user apix
 */

class filedirprocess {

    //mkdir command
    public function mkdir ($projectName=null){

        if($projectName!==null){
            //return
            $path='./src/app/'.$projectName;
            if(!file_exists($path)){
                return mkdir($path, 0777);
            }

            return false;


        }

    }

    //touch command
    public function touch($filename=null,$param=null){

        if($filename!==null){

            $path='./src/app/'.$filename;
            if(!file_exists($path)){
                return touch($path);
            }

            return false;
        }

    }
}