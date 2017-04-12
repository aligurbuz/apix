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

class staticPathModel {

    /**
     * @var param bootFile
     * it is boot resolve
     * for service base controller
     */
    public static $accessLimitationYamlPath='src/store/provisions/limitation';

    /**
     * @var param api doc
     * it is namespace for api documentation
     * for service path run
     */
    public static $apiDocNamespace='\\src\\store\\declarations\\src\\index';

    /**
     * @var param api platform
     * it is namespace for api platform
     * for service path run
     */
    public static $apiPlatformNamespace='\\src\\store\\services\\platform';



}