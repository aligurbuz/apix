<?php

namespace lib;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

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

    /**
     * Method getYaml.
     * The Symfony Yaml component is very simple and consists of two main classes:
     * one parses YAML strings (Parser), and the other dumps a PHP array to a YAML string (Dumper).
     * If an error occurs during parsing, the parser throws a ParseException exception
     * indicating the error type and the line in the original YAML string where the error occurred:
     * return type container
     */
    public static function getYaml($file=null){
        if($file!==null){
            try {
                return Yaml::parse(file_get_contents($file));
            } catch (ParseException $e) {
                return "Unable to parse the YAML string :". $e->getMessage();
            }
        }

    }


    /**
     * Method dumpYaml.
     * The Symfony Yaml component is very simple and consists of two main classes:
     * one parses YAML strings (Parser), and the other dumps a PHP array to a YAML string (Dumper).
     * If an error occurs during parsing, the parser throws a ParseException exception
     * indicating the error type and the line in the original YAML string where the error occurred:
     * return type container
     */
    public static function dumpYaml($data=array(),$yamlPath=null){
        if(is_array($data)){
            $yaml = Yaml::dump($data);
            return file_put_contents($yamlPath, $yaml);
        }

    }
}