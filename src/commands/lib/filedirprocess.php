<?php
/**
 * File directory project.
 * type string
 * package:file process runner
 * user apix
 */

class filedirprocess {

    //page create command
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
}