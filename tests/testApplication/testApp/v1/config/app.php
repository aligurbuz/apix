<?php
/**
 * container app controller
 * it is mainly service app provider for service
 * service app provider
 */

namespace src\app\testApp\v1\config;

class app
{

    /**
     * project app.
     *
     * class loc container call access for every service.
     *
     * @param string
     * @return response container runner
     */
    public function container()
    {
        return [

            'base' =>'\\src\\app\\testApp\\v1\\serviceBaseController'
        ];
    }


    /**
     * project app.
     *
     * class static call access for every service.
     *
     * @param string
     * @return response container runner
     */
    public function staticProvider()
    {
        return [];
    }

    /**
     * get definitive app.
     * definition:classess is defined by user
     * and it is called as IOS,MOBILE,vs..
     * @param type dependency injection and function
     * @return array
     */
    public static function getAppDefinition()
    {
        return [];
    }

    /**
     * get class alias app.
     * definition:classess is defined by user
     * and it is called as IOS,MOBILE,vs..
     * @param type dependency injection and function
     * @return array
     */
    public static function getAppClassAlias()
    {
        return [
            'Adapter'=>'src\app\testApp\v1\serviceAdapterController'
        ];
    }

}
