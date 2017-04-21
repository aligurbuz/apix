<?php
namespace lib;
use Symfony\Component\Yaml\Yaml;
use src\store\services\httprequest as request;
use src\store\services\httpSession;
class serviceDumpObjects {
    private $requestServiceMethodReal;
    private $requestServiceMethod;
    private $other;
    private $serviceYamlFile;
    private $yInfo=array();
    private $yInfoExtra=array();
    private $yObjects=array();
    private $request;
    private $oArr=array();
    private $oInfo=array();
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
        error_reporting(0);
        $this->requestServiceMethodReal=$requestServiceMethodReal;
        $this->requestServiceMethod=$requestServiceMethod;
        $this->other=$other;
        $this->serviceYamlFile='./'.src.'/'.app.'/'.version.'/__call/'.service.'/yaml/expected/'.service.'_'.strtolower(request).'_'.method.'.yaml';
        $this->request=new request();
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
        //$this->tokenInfoDump();
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

        foreach($requestServiceMethodReal as $key=>$value){
            if(is_array($value)){
                $this->recursiveArray($value);

            }
            else{
                $this->oArr[$key]=gettype($value);
                $this->oInfo[$key]=null;
            }
        }
        return [
            'yObjects'=>$this->oArr,
            'yInfo'=>$this->oInfo
        ];
    }

    /**
     * get tokenInfoDump method.
     *
     * outputs get file.
     *
     * @param string
     * @return response tokenInfoDump runner
     */
    private function recursiveArray($value){
        $list=[];
        if(is_array($value)){
            foreach($value as $v1=>$v2){
                if(is_array($v2)){
                    $this->recursiveArray($v2);
                }
                else{
                    $this->oArr[$v1]=gettype($v2);
                    $this->oInfo[$v1]=null;
                }

            }
        }

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
    private function yamlProcess($status=false){
        $value = Yaml::parse(file_get_contents($this->serviceYamlFile));
        if(!$status){
            //values
            $session=new httpSession();
            if(!file_exists($this->serviceYamlFile)){
                $session->remove('standardDumpList');
            }


            $yaml = Yaml::dump(['http'=>strtolower(request),
                    'servicePath'=>''.app.'/'.service.'/'.method.'',
                    'data'=>$this->namedDataDumpList($session,$this->yObjects,$querydata),
                    'headers'=>$this->getClientHeaders($session,null)
                ]+$this->requestGetProcess($session) + $this->requestPostProcess($session) +['info'=>$this->yInfo+$this->yInfoExtra]
            );
            return $yaml;
        }
        return $value;
    }
    /**
     * get requestGetMethodCallback method.
     *
     * outputs requestGetMethodCallback method.
     *
     * @param string
     * @return response requestGetMethodCallback runner
     */
    private function namedDataDumpList($session,$data,$querydata=null){
        $list=[];



        if(count($this->getClientHeaders($session,$data))){
            return $session->get('standardDumpList');
        }

        if(count($this->request->getQueryString())){

            $yaml=$this->yamlProcess(true);

            if($session->has("standardDumpList") && strlen($this->joinQueryParam())>0){


                $listBool=true;

                $getDataList='getData:'.$this->joinQueryParam().'';

                $listex=[];
                $reelListex[strlen($getDataList)][$getDataList]=md5(implode(",",$data));
                $lists=[];

                $dataU=$session->get("standardDumpList");
                $dataU[$getDataList]=$data;

                foreach($dataU as $key=>$value){
                    $rl=[];
                    foreach($value as $h=>$hh){
                        $rl[]=''.$h.'__'.$hh.'';
                    }
                    $imp=md5(implode(",",$rl));
                    $reelListex[strlen($key)][$key]=$imp;
                }

                ksort($reelListex);




                foreach ($reelListex as $key=>$value){
                    foreach($value as $a=>$b){
                        if(!in_array($b,$lists)){
                            $lists[]=$b;
                            $listex[$a]=$dataU[$a];
                            $listBool=false;
                        }
                    }
                }



                $session->remove("standardDumpList");
                $session->set("standardDumpList",$listex);
                $this->setInfoExtra($session);




                if($listBool){
                    $getDataList='getData:'.$this->joinQueryParam().'';
                    $list[$getDataList]=$data;
                    foreach ($yaml['data'] as $ykey=>$yvalue){
                        if($ykey!==$getDataList){
                            $list[$ykey]=$yvalue;
                        }
                    }
                    $dataGetJoin=$list;


                    $session->remove("standardDumpList");
                    $session->set("standardDumpList",$dataGetJoin);
                }
                $this->setInfoExtra($session);
            }
        }


        if($session->has("standardDumpList")){

            if(!array_key_exists("standard",$session->get("standardDumpList"))){

                if(count($this->request->getQueryString())){
                    $this->setInfoExtra($session);
                    return $session->get("standardDumpList");
                }
                else{
                    $list['standard']=$session->get("standardDumpList");
                }

            }


            if(!array_key_exists("standard",$session->get("standardDumpList")) && md5(implode(",",$data))!==md5(implode(",",$session->get("standardDumpList")))){
                $session->remove("standardDumpList");
                $session->set("standardDumpList",$data);

                if(count($this->request->getQueryString())){
                    $this->setInfoExtra($session);
                    return $session->get("standardDumpList");
                }
                else{
                    $list['standard']=$data;
                }


            }


            if(array_key_exists("standard",$session->get("standardDumpList")) && md5(implode(",",$data))!==md5(implode(",",$session->get("standardDumpList")['standard']))){
                $dataUpdate=$session->get("standardDumpList");


                if(count($this->request->getQueryString())==0){
                    $dataUpdate['standard']=$data;
                    $session->remove("standardDumpList");
                    $session->set("standardDumpList",$dataUpdate);
                    $this->setInfoExtra($session);
                    return $session->get("standardDumpList");
                }
                else{
                    /*$dataUpdate['standard']=$data;
                    $session->remove("standardDumpList");
                    $session->set("standardDumpList",$dataUpdate);
                    $this->setInfoExtra($session);
                    return $session->get("standardDumpList");*/
                }
            }
        }
        else{
            if(count($this->request->getQueryString())){
                $list['getData:'.$this->joinQueryParam()]=$data;
            }
            else{
                $list['standard']=$data;
            }

        }


        $this->setInfoExtra($session);

        if(count($list)){
            $session->set("standardDumpList",$list);
            return $list;
        }
        else{
            return $session->get("standardDumpList");
        }

    }
    /**
     * get requestGetMethodCallback method.
     *
     * outputs requestGetMethodCallback method.
     *
     * @param string
     * @return response requestGetMethodCallback runner
     */
    private function requestGetMethodCallback($session,$callback){
        if(request=="GET"){
            return $this->requestGetProcess($session);
        }
        else{
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }
    }
    /**
     * get requestGetMethodCallback method.
     *
     * outputs requestGetMethodCallback method.
     *
     * @param string
     * @return response requestGetMethodCallback runner
     */
    private function setInfoExtra($session){
        $forInfo=$session->get("standardDumpList");
        foreach($forInfo as $fKey=>$fValue){
            foreach($forInfo[$fKey] as $ffKey=>$ffValue){
                if(!array_key_exists($ffKey,$this->yInfo)){
                    $this->yInfoExtra[$ffKey]=null;
                }
            }
        }
    }
    /**
     * get requestGetMethodCallback method.
     *
     * outputs requestGetMethodCallback method.
     *
     * @param string
     * @return response requestGetMethodCallback runner
     */
    private function joinQueryParam(){
        $list=[];
        foreach($this->request->getQueryString() as $key=>$value){
            $list[]=$key;
        }
        return implode("&",$list);
    }


    /**
     * get requestGetMethodCallback method.
     *
     * outputs requestGetMethodCallback method.
     *
     * @param string
     * @return response requestGetMethodCallback runner
     */
    private function joinHeaderParam(){
        $list=[];
        foreach($this->request->getClientHeaders() as $key=>$value){
            $list[]=$key;
        }
        return implode("&",$list);
    }


    /**
     * get requestGetMethodCallback method.
     *
     * outputs requestGetMethodCallback method.
     *
     * @param string
     * @return response requestGetMethodCallback runner
     */
    private function getClientHeaders($session,$data=null){
        if(count($this->request->getClientHeaders())){

            if($data!==null){
                $dataU=$session->get('standardDumpList');
                $getDataList='header@'.$this->joinHeaderParam().':'.$this->joinQueryParam().'';
                $dataU[$getDataList]=$data;

                $listex=[];
                $reelListex[strlen($getDataList)][$getDataList]=md5(implode(",",$data));
                $lists=[];

                $dataU[$getDataList]=$data;

                foreach($dataU as $key=>$value){
                    $rl=[];
                    foreach($value as $h=>$hh){
                        $rl[]=''.$h.'__'.$hh.'';
                    }
                    $imp=md5(implode(",",$rl));
                    $reelListex[strlen($key)][$key]=$imp;
                }

                ksort($reelListex);




                foreach ($reelListex as $key=>$value){
                    foreach($value as $a=>$b){
                        if(!in_array($b,$lists)){
                            $lists[]=$b;
                            $listex[$a]=$dataU[$a];
                            $listBool=false;
                        }
                    }
                }

                $session->remove("standardDumpList");
                $session->set("standardDumpList",$listex);
                $this->setInfoExtra($session);
            }


            return $this->request->getClientHeaders();
        }

        return [];
    }
    /**
     * get requestPostProcess method.
     *
     * outputs requestPostProcess method.
     *
     * @param string
     * @return response requestPostProcess runner
     */
    private function requestPostProcess($session){
        $inputList=[];
        if(request=="POST"){
            foreach($this->request->input() as $key=>$value){
                if(is_numeric($value)){
                    $inputList[$key]='integer';
                }
                else{
                    $inputList[$key]='string';
                }

            }
        }


        return ['postData'=>$inputList];
    }
    /**
     * get requestGetProcess method.
     *
     * outputs requestGetProcess method.
     *
     * @param string
     * @return response requestGetProcess runner
     */
    private function requestGetProcess($session){
        $inputList=[];
        foreach($session->get("standardDumpList") as $ykey=>$yvalue){

            if(preg_match('@getData:@is',$ykey)){
                $ykeyStr=explode(":",$ykey);
                $ykeyStrExplode=explode("&",$ykeyStr[1]);

                foreach($ykeyStrExplode as $yexKey=>$yexValue){
                    $inputList[$yexValue]='string';
                }
            }

            if(preg_match('@header\@@is',$ykey)){
                $ykeyStr=explode(":",$ykey);
                $ykeyStrExplode=explode("&",$ykeyStr[1]);

                foreach($ykeyStrExplode as $yexKey=>$yexValue){
                    $inputList[$yexValue]='string';
                }
            }
        }
        return ['getData'=>$inputList];
    }
}