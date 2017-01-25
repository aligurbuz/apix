<?php
if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
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