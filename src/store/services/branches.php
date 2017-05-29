<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;

/**
 * Represents a index class.
 *
 * main call
 * return type string
 */

class branches {

    public $name=null;
    public $method=null;
    public $filename=null;
    public $servicename=null;
    public $instance=null;
    public $modelDir;

    public function __construct(){
        $getModelVar='\\src\\app\\'.app.'\\'.version.'\\serviceBaseController';
        $this->modelDir=(new $getModelVar())->model;
    }


    /**
     * get branch name.
     *
     * @return array
     */
    public static function __callStatic($name,$arguments=[]){

        $border=new self;

        $border->name=$name;

        return $border;
    }

    /**
     * get branch name.
     *
     * @return array
     */
    public function __call($name,$arguments=[]){

        if($this->instance==null){
            $this->filename=$name;
        }
        else{
            $this->method=$name;
            if(count($arguments)==0){
                $arg=[];
            }
            else{
                $arg=$arguments[0];
            }
            return $this->runBranch($arg);
        }


        if($this->instance==null){
            $this->instance=1;
        }

        return $this;
    }

    /**
     * get branch method.
     *
     * @return array
     */
    public function method($method=null){

        if($method!==null){
            $this->method=$method;
        }

        return $this;

    }

    /**
     * get branch file.
     *
     * @return array
     */
    public function file($filename=null){

        if($filename!==null){
            $this->filename=$filename;
        }

        return $this;

    }


    /**
     * get branch service name.
     *
     * @return array
     */
    public function service($servicename=null,$methodName=null){

        if($servicename!==null){
            $this->servicename=$servicename;
        }

        if($methodName!==null){
            $this->method=$methodName;
        }

        if($this->name=="main"){

            return $this->runBranch([]);
        }
        else{
            return $this;
        }


    }

    /**
     * get branch result.
     *
     * @return array
     */
    public function runBranch($arguments){
        $branches='branch'.ucfirst($this->name);
        return $this->$branches($arguments);
    }

    /**
     * get branch source.
     *
     * @return array
     */
    public function branchMain($arguments){

        //get method
        $method=$this->getMethod().'Action';

        //get file name
        $file=$this->getFile();

        //get service name
        $service=$this->getService();

        if($service==service){
            return null;
        }

        if(defined("devPackage")){
            $sourcename='\\src\\store\\packages\\dev\\'.$service.'\\branches\\source\\'.strtolower(request).'\\'.$file;
        }
        else{
            $sourcename='\\src\\app\\'.app.'\\'.version.'\\__call\\'.$service.'\\'.strtolower(request).'Service';
        }

        $container = \DI\ContainerBuilder::buildDevContainer();
        return $container->get($sourcename)->$method($arguments);
    }


    /**
     * get branch source.
     *
     * @return array
     */
    public function branchSource($arguments){

        //get method
        $method=$this->getMethod();

        //get file name
        $file=$this->getFile();

        //get service name
        $service=$this->getService();

        if(defined("devPackage")){
            $sourcename='\\src\\store\\packages\\dev\\'.$service.'\\source\\bundle\\'.$file.'\\index';
        }
        else{
            $sourcename='\\src\\app\\'.app.'\\'.version.'\\__call\\'.$service.'\\source\\bundle\\'.$file.'\\index';
        }

        $container = \DI\ContainerBuilder::buildDevContainer();
        return $container->get($sourcename)->$method($arguments);
    }


    /**
     * get branch query.
     *
     * @return array
     */
    public function branchQuery($arguments){

        //get method
        $method=$this->getMethod();

        //get file name
        $file=$this->getFile();

        //get service name
        $service=$this->getService();

        if(defined("devPackage")){
            $sourcename='\\src\\store\\packages\\dev\\'.$service.'\\devpack\\model\\'.$this->modelDir.'\\builder\\'.$file.'Builder';
        }
        else{
            $sourcename='\\src\\app\\'.app.'\\'.version.'\\model\\'.$this->modelDir.'\\builder\\'.$file.'Builder';
        }

        $container = \DI\ContainerBuilder::buildDevContainer();

        if(count($arguments)){
            $queryBuild=$container->get($sourcename)->$method($arguments);
        }
        else{
            $queryBuild=$container->get($sourcename)->$method();
        }
        return $queryBuild;
    }




    /**
     * get branch source.
     *
     * @return array
     */
    private function getMethod(){

        return ($this->method!==null) ? $this->method : 'index';
    }


    /**
     * get branch source name.
     *
     * @return array
     */
    private function getFile(){

        return ($this->filename!==null) ? $this->filename : 'index';
    }

    /**
     * get branch source service name.
     *
     * @return array
     */
    private function getService(){

        return ($this->servicename!==null) ? $this->servicename : service;
    }





}
