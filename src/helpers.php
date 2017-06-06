<?php
if (!function_exists('dd')) {
    function dd()
    {
        header('Content-Type: application/text');
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

if (!function_exists('pr')) {
    function pr()
    {
        echo '<pre>';
        $args = func_get_args();
        print_r($args);
        echo '</pre>';
        die();
    }
}

if (!function_exists('env')) {
    function env($localdata,$proddata)
    {
        $localdata=getenv($localdata);
        return ($localdata===false) ? $proddata : $localdata;
    }
}

if (!function_exists('app')) {
    function app($class=null)
    {
        if($class!==null){
            return \Container::$class();
        }

        return false;
    }
}


if (!function_exists('environment')) {
    function environment()
    {
        return \Apix\environment::get();
    }
}


if (!function_exists('trans')) {
    function trans($data=null,$langname=null)
    {
        if($data!==null){

            $getbase=\Apix\StaticPathModel::getAppServiceBase();

            if($langname==null){
                return \Apix\LanguageDefinitor::get($data,$getbase->getLocalization(),$getbase->getLocalization());
            }
            return \Apix\LanguageDefinitor::get($data,$langname,$getbase->getLocalization());

        }
        return null;
    }
}