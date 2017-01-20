<?php
/*
 * This file is client and super service call info of the global service.
 *
 * client and super call info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;

/**
 * Represents a super service call class.
 *
 * main call
 * return type string
 */

class superservicecalls {

    /**
     * superservice calls set data.
     *
     * @return super service class
     */
    public function __call($name,$args){
       return $this->ready(true,$name);
    }

    /**
     * superservice calls set data.
     *
     * @return super service class
     */
    public function ready($status=false,$method=null){
        //set return
        if($status){
            $serviceReady=\app::resolve("\\src\\app\\".app."\\".version."\\serviceReadyController");
            $handle=(object)$serviceReady->handle();
            $handlemethod=explode("::",$handle->$method);
            $srcapp="%src%app%".app."";
            if(array_key_exists(1,$handlemethod)){
                $handlemethodclass=$handlemethod[0];
                $handlemethodclassmethod=$handlemethod[1];
                $replacehandlemethodclass=str_replace("\\","%",$handlemethodclass);
                if(preg_match('@'.$srcapp.'@is',$replacehandlemethodclass)){
                    return \app::resolve($handlemethodclass)->$handlemethodclassmethod();
                }
                return [];

            }
            else{
                $replacehandlemethodclass=str_replace("\\","%",$handle->$method);
                if(preg_match('@'.$srcapp.'@is',$replacehandlemethodclass)){
                    return \app::resolve($handle->$method);
                }
                return [];
            }

        }
        return $this;

    }




}
