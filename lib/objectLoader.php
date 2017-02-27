<?php
/*
 * This file is data object loader of the every service.
 *
 * object loader returns array value
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace lib;

class objectLoader {

    /**
     * get object loader params.
     * extra data booting for service method
     *
     * outputs get object.
     *
     * @param string
     * @return response boot object loader runner
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