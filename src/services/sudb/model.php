<?php
/*
 * This file is main part of the sudb.
 *
 * model is called for model file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services\sudb;

/**
 * Represents a index class.
 *
 * main call
 * return type array
 */

class model {

    public $subClassOf=null;


    /**
     * __callStatic method is main method.
     *
     * @return array
     */
    public static function __callStatic($name,$args){
        $instance=new self;
        $subClassOf='\\'.get_called_class();
        $instance->getSubClassOf($subClassOf);
        return $instance->getQuery($name,$args);
    }

    /**
     * getQuery method is main method.
     *
     * @return array
     */
    public function getQuery($name,$args){
        $model=\app::resolve("\\src\\services\\sudb\\builder");
        $model->subClassOf($this->subClassOf);
        if($name=="where"){
            if(!is_callable($args[0])){
                return $model->where($args[0],$args[1],$args[2]);
            }
            else{
                return $model->where($args[0],$model);
            }

        }

        return $model->$name($args);
    }


    /**
     * getQuery method is main method.
     *
     * @return array
     */
    public function getSubClassOf($class=null){
        if($class!==null){
            $this->subClassOf=\app::resolve($class);
        }

    }

}