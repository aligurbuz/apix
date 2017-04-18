<?php namespace lib\bin\commands\lib;
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

    //mkdir command
    public function mkdir_path ($projectName=null){

        if($projectName!==null){
            //return
            $path=$projectName;
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

            if($param!==null AND is_array($param)){

                if(!file_exists($path)){
                    touch($path);
                }

                return $this->fopenprocess($path,$param);

            }else{

                if(!file_exists($path)){
                    return touch($path);
                }
            }


            return false;
        }

    }

    //command touch command
    public function command($filename=null,$param=null){

        if($filename!==null){

            $path='./src/store/commands/'.$filename;

            if($param!==null AND is_array($param)){

                if(!file_exists($path)){
                    touch($path);
                }

                return $this->fopenprocess($path,$param);

            }else{

                if(!file_exists($path)){
                    return touch($path);
                }
            }


            return false;
        }

    }


    //touch command
    public function touch_path($filename=null,$param=null){

        if($filename!==null){

            $path=$filename;

            if($param!==null AND is_array($param)){

                if(!file_exists($path)){
                    touch($path);
                }

                return $this->fopenprocess($path,$param);

            }else{

                if(!file_exists($path)){
                    return touch($path);
                }
            }


            return false;
        }

    }

    //fopen process
    public function fopenprocess($path,$param){

        $executionPath="./lib/bin/commands/execution/".$param['execution'].".php";
        $dt = fopen($executionPath, "r");
        $content = fread($dt, filesize($executionPath));
        fclose($dt);

        foreach ($param['params'] as $key=>$value){

            $content=str_replace("__".$key."__",$value,$content);
        }


        $dt = fopen($path, "w");
        fwrite($dt, $content);
        fclose($dt);

        return true;


    }
}