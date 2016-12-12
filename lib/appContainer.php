<?php

namespace lib;

class appContainer {

    public function get(){

        $app=\app::getClassAlias();

        if(is_array($app) AND count($app)){
            foreach ($app as $alias=>$class){
                class_alias($class,$alias);
            }
        }

        return;

    }
}