<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class version {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //service create command
    public function move ($data){

        //usage : api move create project d:v1 m:v2


        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){

                //$sourcepath=''.$app_path.''.$slashes.'Api'.$slashes.'Custom'.$slashes.''.ucfirst($this->argument("var1")).'';
                //$destinationpath=''.$app_path.''.$slashes.'Api'.$slashes.'Custom'.$slashes.''.ucfirst($this->argument("var2")).'';

                $fl=[];
                foreach ($value as $project=>$service){

                    $fl[]='./src/app/'.$project.'/'.$this->getParams($data)[2]['m'].'/serviceBaseController.php';
                    $fl[]='./src/app/'.$project.'/'.$this->getParams($data)[2]['m'].'/serviceLogController.php';
                    $fl[]='./src/app/'.$project.'/'.$this->getParams($data)[2]['m'].'/serviceReadyController.php';

                    $sourcepath='./src/app/'.$project.'/'.$this->getParams($data)[1]['d'].'';
                    $destinationpath='./src/app/'.$project.'/'.$this->getParams($data)[2]['m'].'';


                    if(!file_exists($destinationpath))
                    {
                        mkdir($destinationpath,0777,true);
                        chmod($destinationpath,0777);
                        $this->xcopy($sourcepath,$destinationpath);

                        $list=[];
                        $return=$this->listFolderFiles($destinationpath,"/");


                        foreach ($return as $key=>$value)
                        {
                            if(is_array($return[$key]))
                            {
                                foreach ($return[$key] as $a=>$b)
                                {
                                    if(is_array($b))
                                    {
                                        foreach ($b as $x)
                                        {
                                            $list[]=$x;
                                        }
                                    }
                                    else
                                    {
                                        $list[]=$b;
                                    }
                                }
                            }


                        }

                        $reallist=[];
                        foreach ($list as $lkey=>$lvalue){
                            if(is_array($lvalue)){
                                foreach($lvalue as $a=>$b){
                                    if(is_array($b)){
                                        foreach($b as $x=>$y){
                                            $reallist[]=$y;
                                        }
                                    }
                                    else{
                                        $reallist[]=$b;
                                    }
                                }
                            }
                            else{
                                $reallist[]=$lvalue;
                            }
                        }

                        foreach($reallist as $rkey=>$rvalue){
                            if(is_array($rvalue)){
                                foreach($rvalue as $aa=>$bb){
                                    $fl[]=$bb;
                                }
                            }
                            else{
                                $fl[]=$rvalue;
                            }
                        }


                        foreach ($fl as $val)
                        {
                            $dosya =$val;
                            $dt = @fopen($dosya, "rb");
                            $icerik =@fread($dt, filesize($dosya));
                            $icerik=preg_replace('@v(\d+)@',"".$this->getParams($data)[2]['m']."",$icerik);

                            $dt = fopen($dosya, 'w');

                            fwrite($dt,$icerik);
                            fclose($dt);
                        }

                        return "version has been created";
                    }
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


    /**
     * Copy a file, or recursively copy a folder and its contents
     * @author      Aidan Lister <aidan@php.net>
     * @version     1.0.1
     * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @param       int      $permissions New folder creation permissions
     * @return      bool     Returns true on success, false on failure
     */
    public function xcopy($source, $dest, $permissions = 0777)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }


        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }


        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            $this->xcopy("$source/$entry", "$dest/$entry", $permissions);
        }

        // Clean up
        $dir->close();
        return true;
    }


    /**
     * Copy a file, or recursively copy a folder and its contents
     * @author      Aidan Lister <aidan@php.net>
     * @version     1.0.1
     * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
     * @param       string   $source    Source path
     * @param       string   $dest      Destination path
     * @param       int      $permissions New folder creation permissions
     * @return      bool     Returns true on success, false on failure
     */
    public function listFolderFiles($dir,$slash,$x=false)
    {
        $ffs = scandir($dir);
        $list=[];

        if($x)
        {

        }
        else
        {
            $list=[];
        }

        foreach($ffs as $ff){
            if($ff != '.' && $ff != '..'){
                $path="".$dir."/".$ff."";


                if(is_dir($path))
                {
                    $list[]=$this->listFolderFiles($path,$slash,true);
                }
                else
                {
                    $list[]=$path;

                }
            }
        }



        return $list;


    }

}