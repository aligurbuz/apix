<?php
/*
 * This file is rate limiter for every service
 * rate limiter for service
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
     * get file rateLimitQuery params.
     * rateLimitQuery for service method
     *
     * outputs get handle.
     *
     * @param string
     * @return response rateLimitQuery params runner
     */
    public function handle(){
        $status=true;
        if($this->getStatusRule()){
            return $this->getAccessRuleProcess();
        }
        return $status;

    }

    /**
     * get status rule rateLimitQuery params.
     * rateLimitQuery for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response rateLimitQuery status runner
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
     * get file rateLimitQuery params.
     * access rule process for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response access rule process params runner
     */
    public function getAccessRuleProcess(){

        $rule=$this->checkRuleExists();
        if($this->setAccessRuleYaml($rule)){
            return $this->getLogicResult($rule);
        }
        return false;


    }


    /**
     * get file rateLimitQuery params.
     * get logic result for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response boot logic result runner
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
     * get file rateLimitQuery params.
     * expire time update for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response expire time update params runner
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
     * get file rateLimitQuery params.
     * all time all counters for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response boot all time counters runner
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
     * get file rateLimitQuery params.
     * check rule exists for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response check rule exists params runner
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
     * get file rateLimitQuery params.
     * throttle for service method
     *
     * outputs get throttle.
     *
     * @param string
     * @return response throttle params runner
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
     * get file rateLimitQuery params.
     * request for service method
     *
     * outputs get request.
     *
     * @param string
     * @return response request params runner
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
     * get file rateLimitQuery params.
     * date process for service method
     *
     * outputs get date process.
     *
     * @param string
     * @return response date process params runner
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
     * get file rateLimitQuery params.
     * project rule access for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response project rule access params runner
     */
    public function getProjectAccessRuleClass(){
        if(file_exists($this->getProjectAccessRule())){
            return $this->getProjectAccessRule();
        }
        return null;
    }

    /**
     * get file rateLimitQuery params.
     * access rule yaml for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response access rule yaml params runner
     */
    public function setAccessRuleYaml($rule,$data=null){
        
        if($this->checkServiceExists()){
            if(file_exists($this->getAccessRuleYaml())){
                if($data===null){
                    $dataRule=$this->getUpdateWrapList($this->yamlProcess(),$rule);
                }
                else{
                    $dataRule=$data;
                }

                return $this->yamlProcess("dump",$this->dataRuleDump($dataRule,$rule));
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
     * get file rateLimitQuery params.
     * check key control for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response check key control params runner
     */
    public function dataRuleDump($data,$rule){
        $keyTune=$this->getKeyParam($rule);
        if(!array_key_exists($keyTune,$data['data'])){
            $data['data'][$keyTune][service]['timeStart']=$this->time;
            $data['data'][$keyTune][service]['timeUpdate']=$this->time;
            $data['data'][$keyTune][service]['timeAllCounter']=1;
            $data['data'][$keyTune][service]['allCount']=1;
            $data['data'][$keyTune]['wrap']=$rule['restrictions'][''.$this->checkKeyControl($rule,true).'::'.$this->getKeyParam($rule).''];
            $data['data'][$keyTune]['wrap']['dateprocess']=$this->time;
        }

        return $data;
    }


    /**
     * get file rateLimitQuery params.
     * check key control for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response check key control params runner
     */
    public function checkKeyControl($rule,$type=false){
        if(array_key_exists('ip::'.$this->request->getClientIp(),$rule['restrictions'])){
            if($type===false){
                return true;
            }
            return 'ip';

        }
        if($type===false){
            return $this->getKeyParam($rule);
        }
        return 'token';


    }

    /**
     * get file rateLimitQuery params.
     * yaml process for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response yaml process params runner
     */
    public function yamlProcess($type="parse",$rule=null){

        if($type=="parse"){
            if(file_exists($this->getAccessRuleYaml())){
                return Yaml::parse(file_get_contents($this->getAccessRuleYaml()));
            }
            return ['data'=>[]];

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
     * get file rateLimitQuery params.
     * wrap list for service method
     *
     * outputs get wrap list.
     *
     * @param string
     * @return response wrap list params runner
     */
    public function getUpdateWrapList($data,$rule){

        if(array_key_exists($this->getKeyParam($rule),$data['data'])){
            if(array_key_exists(service,$data['data'][$this->getKeyParam($rule)])){
                foreach($data['data'][$this->getKeyParam($rule)][service] as $key=>$val){
                    if($key=="timeUpdate"){
                        $data['data'][$this->getKeyParam($rule)][service]['timeUpdate']=$this->time;
                    }
                    if($key=="timeAllCounter"){
                        $data['data'][$this->getKeyParam($rule)][service]['timeAllCounter']=$data['data'][$this->getKeyParam($rule)][service]['timeAllCounter']+1;
                    }

                    if($key=="allCount"){
                        $data['data'][$this->getKeyParam($rule)][service]['allCount']=$data['data'][$this->getKeyParam($rule)][service]['allCount']+1;
                    }
                }
            }
            else{
                $data['data'][$this->getKeyParam($rule)][service]['timeStart']=$this->time;
                $data['data'][$this->getKeyParam($rule)][service]['timeUpdate']=$this->time;
                $data['data'][$this->getKeyParam($rule)][service]['timeAllCounter']=1;
                $data['data'][$this->getKeyParam($rule)][service]['allCount']=1;
                $data['data'][$this->getKeyParam($rule)]['wrap']=$rule['restrictions'][''.$this->checkKeyControl($rule,true).'::'.$this->getKeyParam($rule).''];
                $data['data'][$this->getKeyParam($rule)]['wrap']['dateprocess']=$this->time;

            }
        }
        else{
            $data['data'][$this->getKeyParam($rule)][service]['timeStart']=$this->time;
            $data['data'][$this->getKeyParam($rule)][service]['timeUpdate']=$this->time;
            $data['data'][$this->getKeyParam($rule)][service]['timeAllCounter']=1;
            $data['data'][$this->getKeyParam($rule)][service]['allCount']=1;
            $data['data'][$this->getKeyParam($rule)]['wrap']=$rule['restrictions'][''.$this->checkKeyControl($rule,true).'::'.$this->getKeyParam($rule).''];
            $data['data'][$this->getKeyParam($rule)]['wrap']['dateprocess']=$this->time;
        }



        return $data;

    }



    /**
     * get file rateLimitQuery params.
     * check service exists for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response check service exists params runner
     */
    public function checkServiceExists(){

        $path=root.'/src/app/'.app.'/'.version.'/__call/'.service.'/getService.php';
        if(file_exists($path)){
            return true;
        }
        return false;
    }

    /**
     * get file access rule yaml params.
     * access rule yaml for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response access rule yaml params runner
     */
    public function getAccessRuleYaml(){

        return root.'/'.staticPathModel::$accessLimitationYamlPath.'/yaml/'.app.'_accessPointer.yaml';
    }

    /**
     * get file rateLimitQuery params.
     * project rule for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response rule params runner
     */
    public function getProjectAccessRule(){

        return root.'/'.staticPathModel::$accessLimitationYamlPath.'/'.app.'_accessRules.php';
    }

    /**
     * get file rateLimitQuery params.
     * throttle information for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response throttle information params runner
     */
    public function getServiceThrottleInformation($rule){
        $list=[];
        $list['data']=$this->getThrottleWrapList($rule);
        $list['rule']['dateprocess']=$this->time;

        return $list;
    }


    /**
     * get file rateLimitQuery params.
     * throttle wrap list for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response throttle wrap list params runner
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
     * get file rateLimitQuery params.
     * cond for throttle for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response cond for throttle params runner
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
     * get file rateLimitQuery params.
     * get key param for service method
     *
     * outputs get rateLimitQuery.
     *
     * @param string
     * @return response get key param params runner
     */
    public function getKeyParam($rule){
        if($this->checkKeyControl($rule,true)=="ip"){
            return $this->request->getClientIp();
        }
        else{
            if(\app::checkToken()){
                return \app::getUrlParam("_token");
            }
            return null;

        }
    }






}