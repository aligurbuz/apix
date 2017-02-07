<?php
/**
 * Service ready controller
 * it is mainly service ready controller for service
 * service provider
 */

namespace src\app\__projectName__\v1;


class serviceReadyController
{
    /**
     * handle method.
     *
     * @param type ready class and function
     * @return array
     */
    public function handle(){
        return [
            'base'=>'\src\app\__projectName__\v1\serviceBaseController'
        ];
    }
}