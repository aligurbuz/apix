<?php
/*
 * This file is response method for every service
 * default : response data array
 * managed as webservice response method in main controller
 * return @array
 */
namespace lib;

class objectLoader {

    /**
     * get file boot params.
     * booting for service method
     *
     * outputs get boot.
     *
     * @param string
     * @return response boot params runner
     */
    public function boot(){
        $objectLoader="\\src\\provisions\\objectloader";
        $objectLoader=\app::resolve($objectLoader);
        if($objectLoader->status){
            $objectLoaderMethod=request.'ObjectLoader';

            $objectLoaderExcept=strtolower(request).'Except';

            $objectMethodicCall=$objectLoader->$objectLoaderMethod();

            $exceptapp=app.'/'.service;

            if(in_array($exceptapp,$objectLoader->$objectLoaderExcept())){

                $objectMethodicCall=[];
            }

            $serviceobjectLoader="\\src\\app\\".app."\\v1\\provisions\\objectloader";
            $serviceobjectLoader=\app::resolve($serviceobjectLoader);
            $serviceobjectLoaderMethod=request.'ObjectLoader';

            $servicemethodicCall=$serviceobjectLoader->$serviceobjectLoaderMethod();
            $s_serviceobjectLoaderMethodExcept=strtolower(request).'Except';

            if(in_array(service,$serviceobjectLoader->$s_serviceobjectLoaderMethodExcept())){

                $servicemethodicCall=[];
            }

            //individual method like getStk()
            $s_serviceobjectLoader="\\src\\app\\".app."\\v1\\provisions\\objectloader";
            $s_serviceobjectLoader=\app::resolve($s_serviceobjectLoader);
            $s_serviceobjectLoaderMethod=strtolower(request).''.ucfirst(service);

            $s_serviceobjectLoaderMethodcall=[];
            if(method_exists($s_serviceobjectLoader,$s_serviceobjectLoaderMethod)){
                $s_serviceobjectLoaderMethodcall=$s_serviceobjectLoader->$s_serviceobjectLoaderMethod();
            }

            return array_merge_recursive($servicemethodicCall,$s_serviceobjectLoaderMethodcall,$objectMethodicCall);
        }

        return [];

    }



}