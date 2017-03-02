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
    public static $accessLimitationYamlPath='src/provisions/limitation';



}