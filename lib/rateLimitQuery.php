<?php
/*
 * This file is response method for every service
 * default : response data array
 * managed as webservice response method in main controller
 * return @array
 */
namespace lib;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use src\services\httprequest as request;
use src\provisions\limitation\accessRules as rule;

class rateLimitQuery {

    public $request;
    public $time;
    /**
     * get response Out construct.
     * booting resolve
     *
     * outputs get boot.
     *
     * @internal param $string
     */
    public function __construct(){
        //get client request info
        $this->request=new request();
        $this->time=time();
    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function handle(){
        $status=true;
        return $this->checkForDeleteExistData(function() use ($status){
            if($this->getStatusRule()){
                return $this->getAccessRuleProcess();
            }
            return $status;
        });

    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getStatusRule(){
        if($this->getProjectAccessRuleClass()===null){
            return rule::$status;
        }
        else{
            $projectClass='\\src\\provisions\\limitation\\'.app.'_accessRules';
            return $projectClass::$status;
        }

    }


    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getAccessRuleProcess(){

        $rule=$this->checkRuleExists();
        return $this->setAccessRuleYaml($rule);


    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function checkRuleExists(){

        if($this->getProjectAccessRuleClass()===null){
            $rule=rule::handle();
        }
        else{
            $projectClass='\\src\\provisions\\limitation\\'.app.'_accessRules';
            $rule=$projectClass::handle();
        }
        return $rule;


    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function checkValueArrayData(){
        return true;

    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function checkForDeleteExistData($callback){
        if(!$this->checkValueArrayData()){
            unlink($this->getAccessRuleYaml());
            return call_user_func($callback);
        }
        if(is_callable($callback)){
            return call_user_func($callback);
        }
    }



    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getProjectAccessRuleClass(){
        if(file_exists($this->getProjectAccessRule())){
            return $this->getProjectAccessRule();
        }
        return null;
    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function setAccessRuleYaml($rule){

        if($this->checkServiceExists()){
            if(file_exists($this->getAccessRuleYaml())){
                $dataRule=$this->getUpdateWrapList($this->yamlProcess());
                return $this->yamlProcess("dump",$dataRule);
            }
            else{
                if($this->checkKeyControl($rule)){
                    return $this->yamlProcess("dump",$this->getServiceThrottleInformation($rule));
                }
                return true;

            }
        }

        return true;

    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function checkKeyControl($rule){
        if(array_key_exists('ip::'.$this->request->getClientIp(),$rule['restrictions'])){
            return true;
        }
        return false;

    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function yamlProcess($type="parse",$rule=null){

        if($type=="parse"){
            return Yaml::parse(file_get_contents($this->getAccessRuleYaml()));
        }

        if($type=="dump"){
            $yaml = Yaml::dump($rule);
            if(file_put_contents($this->getAccessRuleYaml(), $yaml)){
                return true;
            }
            return false;
        }


    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getUpdateWrapList($data){
        foreach($data['data'] as $wrapkey=>$wrapwal){

            if(array_key_exists(service,$data['data'][$wrapkey])){
                foreach($data['data'][$wrapkey][service] as $key=>$val){
                    if($key=="timeUpdate"){
                        $data['data'][$wrapkey][service]['timeUpdate']=$this->time;
                    }
                    if($key=="timeAllCounter"){
                        $data['data'][$wrapkey][service]['timeAllCounter']=$data['data'][$wrapkey][service]['timeAllCounter']+1;
                    }

                    if($key=="allCount"){
                        $data['data'][$wrapkey][service]['allCount']=$data['data'][$wrapkey][service]['allCount']+1;
                    }
                }
            }
            else{
                $data['data'][$wrapkey][service]['timeStart']=$this->time;
                $data['data'][$wrapkey][service]['timeUpdate']=$this->time;
                $data['data'][$wrapkey][service]['timeAllCounter']=1;
                $data['data'][$wrapkey][service]['allCount']=1;
            }





        }
        return $data;

    }



    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function checkServiceExists(){

        $path=root.'/src/app/'.app.'/'.version.'/__call/'.service.'/getService.php';
        if(file_exists($path)){
            return true;
        }
        return false;
    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getAccessRuleYaml(){

        return root.'/'.staticPathModel::$accessLimitationYamlPath.'/yaml/'.app.'_accessPointer.yaml';
    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getProjectAccessRule(){

        return root.'/'.staticPathModel::$accessLimitationYamlPath.'/'.app.'_accessRules.php';
    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getServiceThrottleInformation($rule){
        $list=[];
        $list['data']=$this->getThrottleWrapList($rule);
        $list['rule']['dateprocess']=$this->time;

        return $list;
    }


    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getThrottleWrapList($rule,$type=null){
        $list=[];
        foreach($rule['restrictions'] as $datakey=>$datavalue){
            foreach($rule['restrictions'][$datakey] as $key=>$value){
                if($this->getCondForThrottle($datakey)!==null){
                    if($type===null){
                        $list[$this->getCondForThrottle($datakey)][service]['timeStart']=$this->time;
                        $list[$this->getCondForThrottle($datakey)][service]['timeUpdate']=$this->time;
                        $list[$this->getCondForThrottle($datakey)][service]['timeAllCounter']=1;
                        $list[$this->getCondForThrottle($datakey)][service]['allCount']=1;
                        $list[$this->getCondForThrottle($datakey)]['wrap']=$rule['restrictions'][$datakey];
                    }

                    if($type=="rule"){
                        $list[$key]=$value;
                    }
                }


            }

        }
        return $list;
    }

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getCondForThrottle($cond){
        $cond=explode("::",$cond);
        if($cond[0]=="ip"){
            if($cond[1]==$this->request->getClientIp()){
                return $cond[1];
            }
            return null;
        }
        else{
            return \app::getUrlParam("_token");
        }
    }






}