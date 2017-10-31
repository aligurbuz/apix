<?php

namespace Src\Store\Services;

use Apix\StaticPathModel;
use Apix\Utils;

class pipeline {

    /**
     * @var $pipeline
     */
    public $pipeline;

    /**
     * @var $pipe
     */
    public $pipe;

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

        $this->pipe=$name;
        return $this->callPipes();
    }


    public function callPipes(){

        $callPipes=$this->pipeline->{$this->pipe}();

        $pipelineList=[];
        $pipelineCallBack=[];
        foreach ($callPipes as $key=>$pipelines){

            foreach ($pipelines as $pipelineClass=>$pipelineMethod){

                if(count($pipelineList)){

                    $pipelineCallBack[]=call_user_func([Utils::makeBind($pipelineClass),$pipelineMethod],end($pipelineList));
                }

                $pipelineList[]=Utils::makeBind($pipelineClass)->$pipelineMethod();
            }
        }

        return end($pipelineCallBack);
    }
}
