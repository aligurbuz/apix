<?php
/*
 * This file is bindigs to data as method parameter in method for every service
 * default : bindings empty data array
 * managed as webServiceBoot method in serviceBaseController 
 * configuration : it is boot object in serviceBaseController
 * it is boolean @true @false
 * appBootLoader
 * return @array
 */
namespace lib;

class appBootLoader {

    /**
     * @var param bootFile
     * it is boot resolve
     * for service base controller
     */
    private $bootFile;

    /**
     * get file boot construct.
     * booting resolve
     *
     * outputs get boot.
     *
     * @internal param $string
     */
    public function __construct(){
        $this->bootFile=$this->bootFileResolve();
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
    public function boot($serviceMethod){
        if(true===$this->bootFile->boot){
            $bootListReal=[];
            foreach($this->getBootListValues($this->bootFile->webServiceBoot(),$serviceMethod) as $key=>$value){
                foreach ($value as $key1=>$value1){
                    $bootListReal[$key1]=$value1;
                }
            }
            return $bootListReal;
        }

        return [];
    }


    /**
     * get list value for boot params.
     * webServiceBoot in the service base Controller
     * it is boot ojbect true
     * the specified service name is booted
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    private function getBootListValues($boot=null,$serviceMethod=null){
        if($boot!==null && $serviceMethod!==null){
            $bootList=[];
            if(array_key_exists(service,$boot)){

                //for all method 'all param'
                if(array_key_exists('all',$boot[service])){
                    $bootList[]=$boot[service]['all'];
                }

                // booting with method name
                if(array_key_exists($serviceMethod,$boot[service])){
                    $bootList[]=$boot[service][$serviceMethod];
                }
            }

            return $bootList;
        }
        return [];
    }



    /**
     * get file boot params.
     * Service base controller for booting to service method
     * service base controller boot object is true
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    private function bootFileResolve(){
        return utils::resolve(api."serviceBaseController");

    }




}