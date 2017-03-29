<?php
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class repo {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //service create command
    public function create ($data){

        //using : api repo create projectName repo:repoName || src:repoSrc || src:repoSrc/repoSrcFile

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){

                $project=null;
                foreach($value as $project){
                    $project=$project;
                }

                if(!array_key_exists("repo",$this->getParams($data)[1])){
                    return 'error : project null or no repo key';
                }

                $version=require ('./src/app/'.$project.'/version.php');
                $version=(is_array($version) && array_key_exists('version',$version)) ? $version['version'] : 'v1';
                $list=[];

                if(array_key_exists(2,$this->getParams($data)) && array_key_exists("src",$this->getParams($data)[2])){

                    $srcBundle=explode("/",$this->getParams($data)[2]['src']);
                    if(!file_exists('./src/app/'.$project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0].'/index.php')){
                        $list[]=$this->mkdir($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0]);
                    }

                    if(array_key_exists(1,$srcBundle)){

                        $bundleParamsIndexSrc['execution']='services/repoBundleSrcIndex';
                        $bundleParamsIndexSrc['params']['projectName']=$project;
                        $bundleParamsIndexSrc['params']['bundleName']=$this->getParams($data)[1]['repo'];
                        $bundleParamsIndexSrc['params']['srcName']=$srcBundle[0];
                        $bundleParamsIndexSrc['params']['className']=$srcBundle[1];
                        $list[]=$this->touch($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0].'/'.$srcBundle[1].'.php',$bundleParamsIndexSrc);

                    }
                    else{
                        $bundleParamsIndexSrc['execution']='services/repoBundleSrcIndex';
                        $bundleParamsIndexSrc['params']['projectName']=$project;
                        $bundleParamsIndexSrc['params']['bundleName']=$this->getParams($data)[1]['repo'];
                        $bundleParamsIndexSrc['params']['srcName']=$srcBundle[0];
                        $bundleParamsIndexSrc['params']['className']='index';
                        $list[]=$this->touch($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/src/'.$srcBundle[0].'/index.php',$bundleParamsIndexSrc);
                    }
                }
                else{
                    $list[]=$this->mkdir($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'');
                    $list[]=$this->touch($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/index.html',null);

                    $list[]=$this->mkdir($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/src');
                    $list[]=$this->touch($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/src/index.html',null);

                    $bundleParamsIndex['execution']='services/repoBundleIndex';
                    $bundleParamsIndex['params']['projectName']=$project;
                    $bundleParamsIndex['params']['bundleName']=$this->getParams($data)[1]['repo'];
                    $list[]=$this->touch($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/index.php',$bundleParamsIndex);

                    $bundleParamsInterface['execution']='services/repoBundleInterface';
                    $bundleParamsInterface['params']['projectName']=$project;
                    $bundleParamsInterface['params']['bundleName']=$this->getParams($data)[1]['repo'];
                    $list[]=$this->touch($project.'/'.$version.'/repository/'.$this->getParams($data)[1]['repo'].'/'.$this->getParams($data)[1]['repo'].'Interface.php',$bundleParamsInterface);

                }



                return $this->fileProcessResult($list,function(){
                    return 'repo has been created';
                });
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

            return 'repo fail';
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