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
        return $this->getRuleCond($rule,function() use ($rule){
            return $this->setAccessRuleYaml($rule);
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
        if(file_exists($this->getAccessRuleYaml())){
            $value = Yaml::parse(file_get_contents($this->getAccessRuleYaml()));
            $value=$this->getCleanData($value);
            $valueJsonHash=md5(json_encode($value));
            $ruleJsonHash=md5(json_encode($this->checkRuleExists()));
            if($valueJsonHash!==$ruleJsonHash){
                return false;
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
    public function getRuleCond($rule,$callback){
        $status=false;
        if(array_key_exists("all",$rule) && (array_key_exists("none",$rule['all']) OR !array_key_exists($this->request->getClientIp(),$rule['all']))){
            $status=true;
        }

        if(!$status){
            return call_user_func($callback);
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
        if(file_exists($this->getAccessRuleYaml())){
            $value = Yaml::parse(file_get_contents($this->getAccessRuleYaml()));

            $reelUpdatedYamlFile=$this->getUpdateYamlFile($value,$rule);
            $updatedValueYaml=$reelUpdatedYamlFile['data'];
            $throttle=explode(":",$updatedValueYaml[$reelUpdatedYamlFile['token']][$reelUpdatedYamlFile['ip']]['throttle']);

            if($this->checkThrottleValue($updatedValueYaml,$reelUpdatedYamlFile['token'],$reelUpdatedYamlFile['ip'])===false){
                $timeBlue=$updatedValueYaml[$reelUpdatedYamlFile['token']][$reelUpdatedYamlFile['ip']]['timeStart']+$throttle[0];
                if(time()>$timeBlue){
                    $updatedValueYaml[$reelUpdatedYamlFile['token']][$reelUpdatedYamlFile['ip']]['timeStart']=time();
                    $updatedValueYaml[$reelUpdatedYamlFile['token']][$reelUpdatedYamlFile['ip']]['timeUpdate']=time();
                    $updatedValueYaml[$reelUpdatedYamlFile['token']][$reelUpdatedYamlFile['ip']]['timeAllCounter']=1;
                    $updatedValueYaml[$reelUpdatedYamlFile['token']][$reelUpdatedYamlFile['ip']]['timeServiceCounter'][service]=1;
                    $yaml = Yaml::dump($updatedValueYaml);
                    file_put_contents($this->getAccessRuleYaml(), $yaml);
                    return true;
                }
                $yaml = Yaml::dump($updatedValueYaml);
                file_put_contents($this->getAccessRuleYaml(), $yaml);
                return false;
            }
            $yaml = Yaml::dump($updatedValueYaml);
            file_put_contents($this->getAccessRuleYaml(), $yaml);
            return true;



        }
        else{
            if($this->getThrottleValue($rule)){
                $yaml = Yaml::dump($this->getServiceThrottleInformation($rule));
                if(file_put_contents($this->getAccessRuleYaml(), $yaml)){
                    return true;
                }
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
    public function getUpdateYamlFile($value,$rule){
        if(\app::checkToken()){

        }
        return ['token'=>'all','ip'=>$this->request->getClientIp(),'data'=>$this->getIpUpdateYamlFile($value,$rule)];
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
    public function checkThrottleValue($data,$token,$ip){
        $data=$data[$token][$ip];
        $throttle=explode(":",$data['throttle']);
        $timeDifference=time()-$data['timeStart'];
        if($timeDifference<=$throttle[0]){
            if($data['request']=="all"){
                if($data['timeAllCounter']>$throttle[1]){
                    return false;
                }
                return true;
            }
            else{
                if($data['timeServiceCounter'][service]>$throttle[1]){
                    return false;
                }
                return true;
            }
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
    public function getIpUpdateYamlFile($value,$rule){
        $valueData=[];
        if(array_key_exists("all",$value)){
            $valueData=$value['all'][$this->request->getClientIp()];
            $ruleData=$rule['all'][$this->request->getClientIp()];
            if($valueData['throttle']==$ruleData['throttle'] && $valueData['request']==$ruleData['request']){
                $value['all'][$this->request->getClientIp()]['timeUpdate']=time();
                $value['all'][$this->request->getClientIp()]['timeAllCounter']=$valueData['timeAllCounter']+1;
                $value['all'][$this->request->getClientIp()]['timeServiceCounter'][service]=$valueData['timeServiceCounter'][service]+1;
                $value['all'][$this->request->getClientIp()]['allCount']=$valueData['allCount']+1;
                $value['all'][$this->request->getClientIp()]['serviceCount'][service]=$valueData['serviceCount'][service]+1;

            }


        }

        return $value;


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
        $time=time();
        foreach($rule as $token=>$ip){
            foreach($ip as $ip_key=>$ip_value){
                foreach($ip_value as $key=>$value){
                    $rule[$token][$ip_key]['timeStart']=$time;
                    $rule[$token][$ip_key]['timeUpdate']=$time;
                    $rule[$token][$ip_key]['timeAllCounter']=1;
                    $rule[$token][$ip_key]['timeServiceCounter']=[service=>1];
                    $rule[$token][$ip_key]['allCount']=1;
                    $rule[$token][$ip_key]['serviceCount']=[service=>1];
                }

            }
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
    public function getThrottleValue($rule){
        foreach($rule as $token=>$ip){
            foreach($ip as $key=>$value){
                foreach($value as $throttle_key=>$throttle_value){
                    if($throttle_key=="throttle"){
                        if($throttle_value=="none"){
                            return false;
                        }
                        return true;
                    }
                }

            }
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
    public function getCleanData($value){
        $list=[];
        foreach($value as $token=>$ip){
            foreach($ip as $ipkey=>$vals){
                foreach($vals as $key=>$val){
                    if($key=="throttle" or $key=="request"){
                        $list[$token][$ipkey][$key]=$val;
                    }

                }

            }

        }
        return $list;
    }





}