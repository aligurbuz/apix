<?php
/**
 * container app controller
 * it is mainly service app provider for service
 * service app provider
 */

namespace src\app\mobi\v1\config;


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
    public function container(){

        return [

            'base' =>'\\src\\app\\mobi\\v1\\serviceBaseController'
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
    public function staticProvider(){

        return [

        ];

    }
}