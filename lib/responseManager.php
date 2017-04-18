<?php
/*
 * This file is response method for every service
 * default : response data array
 * managed as webservice response method in main controller
 * return @array
 */
namespace lib;

class responseManager {


    /**
     * get response Out construct.
     * booting resolve
     *
     * outputs get boot.
     *
     * @internal param $string
     */
    public function __construct($responseOutType){
        if($responseOutType=="json"){
            header('Content-Type: application/json');
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
    public function responseManagerBoot($data,$msg=null){

        if(!is_array($data)){
            $data=[$data];
        }

        return $this->getQueryErrorLoad($data,function() use ($data,$msg){
            $developInfo=null;
            if(defined("app") && defined("version") && defined("service")) {
                $developInfo = $this->getDeveloperInformationLoad();
            }

            return $this->getStatusDataEmpty($data,$msg,$developInfo,function() use($data,$msg,$developInfo){
                $serviceBase=utils::resolve(api."serviceBaseController");
                if($serviceBase->objectLoader){
                    $objectData=(new objectLoader())->boot();
                }
                else{
                    $objectData=[];
                }

                $data=['success'=>(bool)true,'statusCode'=>200,
                        'responseTime'=>microtime(true)-time_start,
                        'requestDate'=>date("Y-m-d H:i:s")]+['data'=>$data+$objectData,'development'=>$developInfo];

                return json_encode($data);
            });

        });
    }


    /**
     * get query error params.
     * for values returning from db vs.
     * query error type array
     *
     * outputs get query error.
     *
     * @param array
     * @return response query error runner
     */
    private function getQueryErrorLoad($data,$callback){
        $queryError=[];
        if(array_key_exists("error",$data)){
            if($data['error']){
                $queryError=['success'=>(bool)false]+['error'=>$data];
            }
        }

        if(count($queryError)){
            return json_encode($queryError);
        }
        else{
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }

    }

    /**
     * get getDeveloperInformationLoad.
     * will be added developer information to responseOut.
     * query type array
     *
     * getDeveloperInformationLoad.
     *
     * @param array
     * @return response query getDeveloperInformationLoad runner
     */
    private function getDeveloperInformationLoad(){
        $developer=[];
        $developInfo=null;
        $developerFile=apiPath.'__call/'.service.'/developer.php';
        if(file_exists($developerFile)){
            $developer=require($developerFile);
        }
        if(is_array($developer) && count($developer)){
            $developInfo=$developer;
        }
        return $developInfo;

    }

    /**
     * get getStatusDataEmpty.
     * if responseOut comes empty.
     * query type array
     *
     * getStatusDataEmpty.
     *
     * @param array
     * @return response query getStatusDataEmpty runner
     */
    private function getStatusDataEmpty($data,$msg,$developInfo,$callback){
        if(is_array($data) && count($data)){
            if(is_callable($callback)){
                return call_user_func($callback);
            }
        }

        $msg=($msg!==null) ? $msg : 'data is empty';
        $data=['success'=>(bool)false,'statusCode'=>204,'responseTime'=>microtime(true)-time_start,
                'requestDate'=>date("Y-m-d H:i:s")]+['message'=>$msg,'development'=>$developInfo];

        return json_encode($data);


    }

}