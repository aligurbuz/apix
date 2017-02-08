<?php

namespace lib;
use Symfony\Component\Yaml\Yaml;

class serviceDumpObjects {

    private $requestServiceMethodReal;
    private $requestServiceMethod;
    private $other;
    private $serviceYamlFile;
    private $yInfo=array();
    private $yObjects=array();

    /**
     * service dump constructs.
     *
     * outputs get file.
     *
     * @param $requestServiceMethodReal
     * @param $requestServiceMethod
     * @param $other
     * @internal param $string
     */
    public function __construct($requestServiceMethodReal,$requestServiceMethod,$other){
        $this->requestServiceMethodReal=$requestServiceMethodReal;
        $this->requestServiceMethod=$requestServiceMethod;
        $this->other=$other;
        $this->serviceYamlFile='./'.src.'/'.app.'/'.version.'/__call/'.service.'/yaml/expected/'.service.'_'.strtolower(request).'_'.method.'.yaml';
        $this->dump();
    }

    /**
     * service dump runner method.
     *
     * outputs get file.
     *
     * @param string
     * @return response service dump runner
     */
    public function dump(){

        if($this->requestServiceMethodReal!==null && $this->requestServiceMethod!==null){

            $requestServiceMethodReal=$this->requestServiceMethodReal($this->requestServiceMethodReal);
            $this->yObjects=$requestServiceMethodReal['yObjects'];
            $this->yInfo=$requestServiceMethodReal['yInfo'];

            //file put yaml variables
            file_put_contents($this->serviceYamlFile, $this->yamlProcess());

        }

        //token dump
        $this->tokenInfoDump();
    }


    /**
     * get requestServiceMethodReal method.
     *
     * outputs get file.
     *
     * @param string
     * @return response requestServiceMethodReal runner
     */
    private function requestServiceMethodReal($requestServiceMethodReal){
        $oArr=[];
        $oInfo=[];
        foreach($requestServiceMethodReal as $key=>$value){
            if(is_array($value)){
                foreach($value as $v1=>$v2){
                    $oArr[$v1]=gettype($v2);
                    $oInfo[$v1]=null;
                }
            }
            else{
                $oArr[$key]=gettype($value);
                $oInfo[$key]=null;
            }
        }

        return ['yObjects'=>$oArr,'yInfo'=>$oInfo];
    }


    /**
     * get tokenInfoDump method.
     *
     * outputs get file.
     *
     * @param string
     * @return response tokenInfoDump runner
     */
    private function tokenInfoDump(){
        //token for yaml
        if(array_key_exists("token",$this->other)){
            $yaml = Yaml::dump(['tokenRequest'=>['status'=>$this->other['token'],'getParam'=>['_token'=>'string']]]);
            file_put_contents($this->serviceYamlFile, $yaml);
        }
    }

    /**
     * get yamlProcess method.
     *
     * outputs get file.
     *
     * @param string
     * @return response yamlProcess runner
     */
    private function yamlProcess(){
        //values
        $value = Yaml::parse(file_get_contents($this->serviceYamlFile));
        $yaml = Yaml::dump(['http'=>strtolower(request),
                'servicePath'=>''.app.'/'.service.'/'.method.''
            ]+
            ['data'=>$this->yObjects]
            +$value+['info'=>$this->yInfo]
        );

        return $yaml;
    }
}