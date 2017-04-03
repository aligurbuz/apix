<?php

namespace lib;

class utils {

    /**
     * Class resolve.
     * PHP-DI's container is preconfigured for "plug'n'play", i.e. development environment.
     * By default, PHP-DI will have Autowiring enabled (annotations are disabled by default).
     * return type container
     */
    public static function resolve($class=null){
        if($class!==null){
            $container = \DI\ContainerBuilder::buildDevContainer();
            return $container->get($class);
        }

    }
}