<?php namespace lib\bin\commands;
/**
 * Command write.
 * type array
 * package:command runner
 * user apix
 */


class source {

    public $fileprocess;

    public function __construct(){
        $this->fileprocess=$this->fileprocess();
        require("./lib/bin/commands/lib/getenv.php");
    }


    //service create command
    public function bundle ($data){

        //using : api source bundle projectName:ServiceName bundle:bundleName || src:bundleSrc || src:bundleSrc/bundleSrcFile

        foreach ($this->getParams($data) as $key=>$value){
            if($key==0){

                foreach ($value as $project=>$service){
                    $version=require ('./src/app/'.$project.'/version.php');
                    $version=(is_array($version) && array_key_exists('version',$version)) ? $version['version'] : 'v1';
                    $list=[];

                    if(array_key_exists(2,$this->getParams($data)) && array_key_exists("src",$this->getParams($data)[2])){

                        $srcBundle=explode("/",$this->getParams($data)[2]['src']);
                        if(!file_exists('./src/app/'.$project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/src/'.$srcBundle[0].'/index.php')){
                            $list[]=$this->mkdir($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/src/'.$srcBundle[0]);
                        }

                        if(array_key_exists(1,$srcBundle)){

                            $bundleParamsIndexSrc['execution']='services/sourceBundleSrcIndex';
                            $bundleParamsIndexSrc['params']['projectName']=$project;
                            $bundleParamsIndexSrc['params']['serviceName']=$service;
                            $bundleParamsIndexSrc['params']['bundleName']=$this->getParams($data)[1]['bundle'];
                            $bundleParamsIndexSrc['params']['srcName']=$srcBundle[0];
                            $bundleParamsIndexSrc['params']['className']=$srcBundle[1];
                            $bundleParamsIndexSrc['params']['version']=$version;
                            $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/src/'.$srcBundle[0].'/'.$srcBundle[1].'.php',$bundleParamsIndexSrc);

                            $requestBundleFile='./src/app/'.$project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/index.php';
                            $this->fileprocess->changeClass($requestBundleFile,['use src\app\mobi\v1\__call\stk\app;'=>'use src\app\mobi\v1\__call\stk\app;'.PHP_EOL.'use src\\app\\'.$project.'\\'.$version.'\\__call\\'.$service.'\\source\bundle\\'.$this->getParams($data)[1]['bundle'].'\\src\\'.$srcBundle[0].'\\'.$srcBundle[1].';'
                            ]);

                        }
                        else{
                            $bundleParamsIndexSrc['execution']='services/sourceBundleSrcIndex';
                            $bundleParamsIndexSrc['params']['projectName']=$project;
                            $bundleParamsIndexSrc['params']['serviceName']=$service;
                            $bundleParamsIndexSrc['params']['bundleName']=$this->getParams($data)[1]['bundle'];
                            $bundleParamsIndexSrc['params']['srcName']=$srcBundle[0];
                            $bundleParamsIndexSrc['params']['className']='index';
                            $bundleParamsIndexSrc['params']['version']=$version;
                            $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/src/'.$srcBundle[0].'/'.$srcBundle[0].'.php',$bundleParamsIndexSrc);

                            $requestBundleFile='./src/app/'.$project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/index.php';
                            $this->fileprocess->changeClass($requestBundleFile,['use src\app\mobi\v1\__call\stk\app;'=>'use src\app\mobi\v1\__call\stk\app;'.PHP_EOL.'use src\\app\\'.$project.'\\'.$version.'\\__call\\'.$service.'\\source\bundle\\'.$this->getParams($data)[1]['bundle'].'\\src\\'.$srcBundle[0].'\\'.$srcBundle[0].';'
                            ]);
                        }
                    }
                    else{
                        $list[]=$this->mkdir($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'');
                        $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/index.html',null);

                        $list[]=$this->mkdir($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/src');
                        $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/src/index.html',null);

                        $bundleParamsIndex['execution']='services/sourceBundleIndex';
                        $bundleParamsIndex['params']['projectName']=$project;
                        $bundleParamsIndex['params']['serviceName']=$service;
                        $bundleParamsIndex['params']['bundleName']=$this->getParams($data)[1]['bundle'];
                        $bundleParamsIndex['params']['version']=$version;
                        $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/index.php',$bundleParamsIndex);

                        $bundleParamsInterface['execution']='services/sourceBundleInterface';
                        $bundleParamsInterface['params']['projectName']=$project;
                        $bundleParamsInterface['params']['serviceName']=$service;
                        $bundleParamsInterface['params']['bundleName']=$this->getParams($data)[1]['bundle'];
                        $bundleParamsInterface['params']['version']=$version;
                        $list[]=$this->touch($project.'/'.$version.'/__call/'.$service.'/source/bundle/'.$this->getParams($data)[1]['bundle'].'/'.$this->getParams($data)[1]['bundle'].'Interface.php',$bundleParamsInterface);

                    }



                    return $this->fileProcessResult($list,function(){
                        return 'bundle source has been created';
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
        $libconf=require("./lib/bin/commands/lib/conf.php");
        $file=$libconf['libFile'];
        return new $file();

    }

}