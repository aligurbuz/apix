<?php
if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        header('Content-Type: text/html');
        call_user_func_array('dump', $args);
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
        return \lib\environment::get();
    }
}


if (!function_exists('trans')) {
    function trans($data=null,$langname=null)
    {
        if($data!==null){

            $getbase=\app::resolve("\\src\\app\\".app."\\".version."\\serviceBaseController");

            if($langname==null){
                return \lib\languageDefinitor::get($data,$getbase->getLocalization(),$getbase->getLocalization());
            }
            return \lib\languageDefinitor::get($data,$langname,$getbase->getLocalization());

        }
        return null;
    }
}