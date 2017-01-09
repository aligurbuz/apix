<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;

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
    public function service($servicename=null){

        if($servicename!==null){
            $this->servicename=$servicename;
        }

        return $this;

    }

    /**
     * get branch result.
     *
     * @return array
     */
    public function get(){

        $branches='branch'.ucfirst($this->name);
        return $this->$branches();
    }


    /**
     * get branch source.
     *
     * @return array
     */
    public function branchSource(){

        //get method
        $method=$this->getMethod();

        //get file name
        $file=$this->getFile();

        //get service name
        $service=$this->getService();

        $sourcename='\\src\\app\\'.app.'\\'.version.'\\__call\\'.$service.'\\branches\\source\\'.strtolower(request).'\\'.$file;
        $container = \DI\ContainerBuilder::buildDevContainer();
        return $container->get($sourcename)->$method();
    }


    /**
     * get branch query.
     *
     * @return array
     */
    public function branchQuery(){

        //get method
        $method=$this->getMethod();

        //get file name
        $file=$this->getFile();

        //get service name
        $service=$this->getService();

        $sourcename='\\src\\app\\'.app.'\\'.version.'\\__call\\'.$service.'\\branches\\query\\'.$file;
        $container = \DI\ContainerBuilder::buildDevContainer();
        return ['queryResult'=>$container->get($sourcename)->$method()];
    }


    /**
     * get branch handle.
     *
     * @return array
     */
    public function branchHandle(){

        //get method
        $method=$this->getMethod();

        //get file name
        $file=$this->getFile();

        //get service name
        $service=$this->getService();

        $sourcename='\\src\\app\\'.app.'\\'.version.'\\__call\\'.$service.'\\branches\\handle\\'.$file;
        $container = \DI\ContainerBuilder::buildDevContainer();
        return $container->get($sourcename)->$method();
    }


    /**
     * get branch source.
     *
     * @return array
     */
    private function getMethod(){

        return ($this->method!==null) ? $this->method : 'get';
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
