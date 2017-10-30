<?php

namespace Src\Store\Services;

use Apix\StaticPathModel;

class pipeline {

    /**
     * @var $pipeline
     */
    public $pipeline;

    /**
     * pipeline constructor.
     */
    public function __construct(){

        $this->pipeline=StaticPathModel::getAppServicePipeline();
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name,$args){

        return $this->pipeline->{$name}();
    }
}
