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
        $oArr=[];
        $oInfo=[];

        foreach($requestServiceMethodReal as $key=>$value){
            if(is_array($value)){
                if($key=="queryResult"){
                    foreach($value as $v1=>$v2){
                        if($v1=="data"){
                            foreach($requestServiceMethodReal['queryResult']['data'][0] as $dkey=>$dvalue){
                                $oArr['queryResult'][$v1][$dkey]=gettype($dvalue);
                                $oInfo[$v1][$dkey]=null;
                            }
                        }
                        else{
                            $oArr['queryResult'][$v1]=gettype($v2);
                            $oInfo[$v1]=null;
                        }

                    }
                }
                else{
                    foreach($value as $v1=>$v2){
                        $oArr[$v1]=gettype($v2);
                        $oInfo[$v1]=null;
                    }
                }

            }
            else{
                $oArr[$key]=gettype($value);
                $oInfo[$key]=null;
            }
        }

        return [
            'yObjects'=>$oArr,
            'yInfo'=>$oInfo
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


            $querydata=$this->requestGetMethodCallback($session,function() use ($session){
                return $this->requestPostProcess($session);
            });



            $yaml = Yaml::dump(['http'=>strtolower(request),
                    'servicePath'=>''.app.'/'.service.'/'.method.'',
                    'data'=>$this->namedDataDumpList($session,$this->yObjects,$querydata),
                    'headers'=>$this->getClientHeaders($session)
                ]+$querydata +['info'=>$this->yInfo+$this->yInfoExtra]
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

        foreach ($this->getClientHeaders($session) as $key=>$value){
           $list['header_'.$key]=$data;
        }


        if(count($this->getClientHeaders($session))==0 && count($querydata['getData'])==0){
            if(!$session->has("standardDumpList")){
                $session->set("standardDumpList",$data);
            }

        }


        if(count($querydata['getData'])){

            $yaml=$this->yamlProcess(true);
            $getDataList='getData:'.key( array_slice($querydata['getData'], -1, 1, TRUE ) ).'';
            $list[$getDataList]=$data;
            foreach ($yaml['data'] as $ykey=>$yvalue){
                $list[$ykey]=$yvalue;
            }

            $dataGetJoin=$list;
            $session->remove("standardDumpList");
            $session->set("standardDumpList",$dataGetJoin);

        }

        if($session->has("standardDumpList")){

            if(!array_key_exists("standard",$list)){
                if(array_key_exists("standard",$session->get("standardDumpList"))){
                    return $session->get("standardDumpList");
                }

                $list['standard']=$session->get("standardDumpList");
            }

            if(!array_key_exists("standard",$session->get("standardDumpList")) && md5(implode(",",$data))!==md5(implode(",",$session->get("standardDumpList")))){
                $session->remove("standardDumpList");
                $session->set("standardDumpList",$data);
                $list['standard']=$data;
            }


            if(array_key_exists("standard",$session->get("standardDumpList")) && md5(implode(",",$data))!==md5(implode(",",$session->get("standardDumpList")['standard']))){

                $dataUpdate=$session->get("standardDumpList");

                if(count($this->request->getQueryString())==0){
                    $dataUpdate['standard']=$data;
                    $session->remove("standardDumpList");
                    $session->set("standardDumpList",$dataUpdate);
                    $list['standard']=$data;
                }
                else{

                    foreach($querydata['getData'] as $key=>$value){
                        $dataUpdate['getData:'.$key]=$data;
                        $session->remove("standardDumpList");
                        $session->set("standardDumpList",$dataUpdate);
                        return $session->get("standardDumpList");
                    }

                }

            }




            /*if(md5(implode(",",$data))!==md5(implode(",",$session->get("standardDumpList")['standard']))){
                $dataUpdate=$session->get("standardDumpList");

                if(array_key_exists("standard",$dataUpdate)){
                    $dataUpdate['standard']=$data;
                    $session->remove("standardDumpList");
                    $session->set("standardDumpList",$dataUpdate);
                }

                $session->remove("standardDumpList");
                $session->set("standardDumpList",$data);


            }*/

        }
        else{
            $list['standard']=$data;
        }

        $forInfo=$session->get("standardDumpList");

        foreach($forInfo as $fKey=>$fValue){

            foreach($forInfo[$fKey] as $ffKey=>$ffValue){

                if(!array_key_exists($ffKey,$this->yInfo)){
                    $this->yInfoExtra[$ffKey]=null;
                }
            }

        }


        return $list;

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
    private function getClientHeaders($session){
        $hashData=md5(implode(",",$this->requestServiceMethodReal));
        $headers=$this->request->getClientHeaders();
        if($hashData!==$session->get("serviceDumpHashData")){
            if(count($headers)){
                $session->set("serviceDumpHashDataHeaders",$headers);
                $listHeaders=[];
                foreach($headers as $key=>$value){
                    $listHeaders[$key]=gettype($value[0]);
                }
                return $listHeaders;
            }

        }
        if($session->has("serviceDumpHashDataHeaders")){
            $listHeaders=[];
            foreach($session->get("serviceDumpHashDataHeaders") as $key=>$value){
                $listHeaders[$key]=gettype($value[0]);
            }
            return $listHeaders;
        }
        return null;



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
        foreach($this->request->input() as $key=>$value){
            $inputList[$key]=gettype($value);
        }

        $getList=[];
        foreach($this->request->getQueryString() as $gkey=>$gvalue){
            $getList[$gkey]=gettype($gvalue);
        }
        return ['postData'=>$inputList,'getData'=>$getList];
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
        $hashData=md5(implode(",",$this->requestServiceMethodReal));

        if(!$session->has("serviceDumpHashData")){
            $session->set("serviceDumpHashData",$hashData);
            foreach($this->request->getQueryString() as $key=>$value){
                $inputList[$key]=gettype($value);
            }
            $session->set("serviceDumpHashDataTypes",md5(implode(",",$inputList)));
        }
        else{

            foreach($session->get("standardDumpList") as $ykey=>$yvalue){
                if(preg_match('@getData:@is',$ykey)){
                    $ykeyStr=explode(":",$ykey);
                    $inputList[$ykeyStr[1]]='string';
                }
            }
            if($hashData!==$session->get("serviceDumpHashData")){
                foreach($this->request->getQueryString() as $key=>$value){
                    $inputList[$key]=gettype($value);
                }
            }


        }

        return ['getData'=>$inputList];
    }
}