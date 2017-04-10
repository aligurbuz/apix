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

class platform {

    public $platform=null;
    public $method=null;
    public $filename=null;
    public $instance=null;
    public $service=null;


    /**
     * get branch name.
     *
     * @return array
     */
    public function __call($name=null,$arguments=[]){
       if($this->instance==null){
           if($name!==null){
               $this->platform=$name;
               $this->instance=1;
           }
       }
       else{
           if($this->instance==1){
               if($name!==null){
                   $this->service=service;
                   $this->instance=2;
               }
           }
           else{
               if($name!==null){
                   $this->filename=method;
                   $this->instance=3;
               }
           }

       }

        return $this;
    }



    /**
     * get platform get.
     *
     * @return array
     */
    public function take($callback=null){

        if($this->service==null && $this->filename==null){
            $this->service=service;
            $this->filename=method;
        }

        if(defined("devPackage")){

            $config='\\src\\store\\packages\\dev\\'.service.'\\platform\\config';
            $status=false;
            $instance=true;
            $configMethodMain=''.$this->platform;
            $configMethod=''.$this->platform.'_'.$this->service.'_'.$this->filename;
            if(method_exists($config,$configMethod)){
                $status=\lib\utils::resolve($config)->$configMethod();
                $instance=false;
            }

            if($instance && method_exists($config,$configMethodMain)){
                $status=\lib\utils::resolve($config)->$configMethodMain();
            }

            if($method!==null && $status){
                $classplatform=root.'/src/packages/dev/'.service.'/platform/'.$this->platform.'/'.$this->service.'/'.$this->filename.'.php';
                if(file_exists($classplatform)){
                    $platformname='\\src\\store\\packages\\dev\\'.service.'\\platform\\'.$this->platform.'\\'.$this->service.'\\'.$this->filename;
                    return \lib\utils::resolve($platformname)->$method();
                }
                if(is_callable($callback)){
                    return call_user_func($callback);
                }
                return false;


            }
        }
        else{

            $config='\\src\\store\\app\\'.app.'\\'.version.'\\platform\\config';
            $status=false;
            $instance=true;
            $configMethodMain=''.$this->platform;
            $configMethod=''.$this->platform.'_'.$this->service.'_'.$this->filename;
            if(method_exists($config,'handle')){
                $platformResolve=\lib\utils::resolve($config)->handle();
                $this->platform=$platformResolve;
                $instance=false;
                $status=true;
            }

            if($status){

                $classplatform=root.'/src/app/'.app.'/'.version.'/platform/'.$this->platform.'/'.$this->service.'/'.request.'Service.php';
                if(file_exists($classplatform)){
                    $platformname='\\src\\store\\app\\'.app.'\\'.version.'\\platform\\'.$this->platform.'\\'.$this->service.'\\'.request.'Service';
                    $method=method;
                    $appPlatform=\lib\utils::resolve($platformname);
                    if(method_exists($appPlatform,$method)){
                        return \lib\utils::resolve($platformname)->$method(call_user_func($callback));
                    }

                }
                if(is_callable($callback)){
                    return call_user_func($callback);
                }
                return false;


            }

            if(is_callable($callback)){
                return call_user_func($callback);
            }
            return false;

        }

    }


}
