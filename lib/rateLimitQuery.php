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
        if($this->getStatusRule()){
            return $this->getAccessRuleProcess();
        }
        return $status;

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
        if($this->setAccessRuleYaml($rule)){
            return $this->getLogicResult($rule);
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
    public function getLogicResult($rule){
        if($this->getRequest($rule)=="all"){
            $throttle=$this->getThrottle($rule);
            if(count($throttle)){
                $expire=$throttle[0]+$this->getDateProcess($rule);
                if(time()<$expire){
                    $limiter=(int)$throttle[1];
                    if($this->getAllTimeAllCounters($rule)>$limiter){
                        return false;
                    }
                    return true;
                }
                else{
                    return $this->getExpireTimeUpdate($rule);
                }
            }
            return true;

        }
        else{

            $throttle=$this->getThrottle($rule);
            if(count($throttle)){
                $expire=$throttle[0]+$this->getDateProcess($rule);
                if(time()<$expire){
                    $limiter=(int)$throttle[1];
                    if($this->getAllTimeAllCounters($rule)>$limiter){
                        return false;
                    }
                    return true;
                }
                else{
                    return $this->getExpireTimeUpdate($rule);
                }
            }
            return true;

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
    public function getExpireTimeUpdate($rule){

        $keyTone=$this->yamlProcess();

        if($this->getRequest($rule)=="all"){
            foreach($keyTone['data'][$this->getKeyParam($rule)] as $service=>$val){

                foreach($keyTone['data'][$this->getKeyParam($rule)][$service] as $key=>$val){
                    if($key=="timeStart" || $key=="timeUpdate"){
                        $keyTone['data'][$this->getKeyParam($rule)][$service][$key]=$this->time;
                    }
                    if($key=="timeAllCounter"){
                        $keyTone['data'][$this->getKeyParam($rule)][$service][$key]=1;
                    }
                }
                $keyTone['data'][$this->getKeyParam($rule)]['wrap']['dateprocess']=$this->time;


            }
        }
        else{
            foreach($keyTone['data'][$this->getKeyParam($rule)][service] as $key=>$val){
                if($key=="timeStart" || $key=="timeUpdate"){
                    $keyTone['data'][$this->getKeyParam($rule)][service][$key]=$this->time;
                }
                if($key=="timeAllCounter"){
                    $keyTone['data'][$this->getKeyParam($rule)][service][$key]=1;
                }
            }
            $keyTone['data'][$this->getKeyParam($rule)]['wrap']['dateprocess']=$this->time;
        }

        $keyTone['rule']['dateprocess']=$this->time;

        if($this->setAccessRuleYaml($rule,$keyTone)){
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
    public function getAllTimeAllCounters($rule,$service=null){
        $list=[];
        $data=$this->yamlProcess();
        if($this->getRequest($rule)=="all"){
            foreach($data['data'][$this->getKeyParam($rule)] as $service=>$val){
                foreach($data['data'][$this->getKeyParam($rule)][$service] as $key=>$val){
                    if($key=="timeAllCounter"){
                        $list[]=$val;
                    }
                }
            }
        }
        else{
            foreach($data['data'][$this->getKeyParam($rule)][service] as $key=>$val){
                if($key=="timeAllCounter"){
                    $list[]=$val;
                }
            }
        }



        return array_sum($list);
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
    public function getThrottle($rule){
        $keyTune=$this->getKeyParam($rule);
        $data=$this->yamlProcess();
        if(array_key_exists($keyTune,$data['data'])){
            return explode(":",$data['data'][$keyTune]['wrap']['throttle']);
        }
        return [];

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
    public function getRequest($rule){
        $keyTune=$this->getKeyParam($rule);
        $data=$this->yamlProcess();
        if(array_key_exists($keyTune,$data['data'])){
            return $data['data'][$keyTune]['wrap']['request'];
        }
        return 'all';

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
    public function getDateProcess($rule){
        $keyTune=$this->getKeyParam($rule);
        $data=$this->yamlProcess();
        if(array_key_exists($keyTune,$data['data'])){
            if($this->getRequest($rule)=="all"){
                return $data['data'][$keyTune]['wrap']['dateprocess'];
            }
            return $data['data'][$keyTune][service]['timeStart'];

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
    public function setAccessRuleYaml($rule,$data=null){
        
        if($this->checkServiceExists()){
            if(file_exists($this->getAccessRuleYaml())){
                if($data===null){
                    $dataRule=$this->getUpdateWrapList($this->yamlProcess());
                }
                else{
                    $dataRule=$data;
                }

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
    public function checkKeyControl($rule,$type=false){
        if(array_key_exists('ip::'.$this->request->getClientIp(),$rule['restrictions'])){
            if($type===false){
                return true;
            }
            return 'ip';

        }
        if($type===false){
            return false;
        }
        return 'token';


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
            if(file_exists($this->getAccessRuleYaml())){
                return Yaml::parse(file_get_contents($this->getAccessRuleYaml()));
            }
            return true;

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
                        $list[$this->getCondForThrottle($datakey)]['wrap']['dateprocess']=$this->time;
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

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function getKeyParam($rule){
        if($this->checkKeyControl($rule,true)=="ip"){
            return $this->request->getClientIp();
        }
        else{
            return \app::getUrlParam("_token");
        }
    }






}