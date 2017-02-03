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

class platform {

    public $platform=null;
    public $method=null;
    public $filename=null;
    public $instance=null;


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
                   $this->filename=$name;
                   $this->instance=2;
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
    public function get($method=null,$callback=null){

        if(defined("devPackage")){

            $config='\\src\\packages\\dev\\'.service.'\\platform\\config';
            $status=false;
            $instance=true;
            $configMethodMain=''.$this->platform;
            $configMethod=''.$this->platform.'_'.$this->filename;
            if(method_exists($config,$configMethod)){
                $status=\app::resolve($config)->$configMethod();
                $instance=false;
            }

            if($instance && method_exists($config,$configMethodMain)){
                $status=\app::resolve($config)->$configMethodMain();
            }

            if($method!==null && $status){
                $classplatform=root.'/src/packages/dev/'.service.'/platform/'.$this->platform.'/'.$this->filename.'.php';
                if(file_exists($classplatform)){
                    $platformname='\\src\\packages\\dev\\'.service.'\\platform\\'.$this->platform.'\\'.$this->filename;
                    return \app::resolve($platformname)->$method();
                }
                if(is_callable($callback)){
                    return call_user_func($callback);
                }
                return false;


            }
        }
        else{
            $config='\\src\\app\\'.app.'\\'.version.'\\__call\\'.service.'\\platform\\config';
            $status=false;
            $instance=true;
            $configMethodMain=''.$this->platform;
            $configMethod=''.$this->platform.'_'.$this->filename;
            if(method_exists($config,$configMethod)){
                $status=\app::resolve($config)->$configMethod();
                $instance=false;
            }

            if($instance && method_exists($config,$configMethodMain)){
                $status=\app::resolve($config)->$configMethodMain();
            }

            if($method!==null && $status){
                $classplatform=root.'/src/app/'.app.'/'.version.'/__call/'.service.'/platform/'.$this->platform.'/'.$this->filename.'.php';
                if(file_exists($classplatform)){
                    $platformname='\\src\\app\\'.app.'\\'.version.'\\__call\\'.service.'\\platform\\'.$this->platform.'\\'.$this->filename;
                    return \app::resolve($platformname)->$method(call_user_func($callback));
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
