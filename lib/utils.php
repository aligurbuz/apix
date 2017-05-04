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
     * Class resolve.
     * PHP-DI's container is preconfigured for "plug'n'play", i.e. development environment.
     * By default, PHP-DI will have Autowiring enabled (annotations are disabled by default).
     * return type container
     */
    public static function getAppVersion($app=null){
        if($app!==null){
            $getAppVersionPath=root.'/'.src.'/'.$app.'/version.php';
            if(file_exists($getAppVersionPath)){
                $getAppVersion=require($getAppVersionPath);
                return $getAppVersion['version'];
            }
        }
        return null;

    }


    /**
     * Class resolve.
     * PHP-DI's container is preconfigured for "plug'n'play", i.e. development environment.
     * By default, PHP-DI will have Autowiring enabled (annotations are disabled by default).
     * return type container
     */
    public static function getAppRootNamespace($app=null){
        if($app!==null){
            $getAppRoot='\\src\\app\\'.$app.'\\'.self::getAppVersion($app).'';
            return $getAppRoot;
        }
        return null;

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


    /**
     * Spl auto load register.
     * spl_autoload_register — Register given function as __autoload() implementation
     * Register a function with the spl provided __autoload queue. If the queue is not yet activated it will be activated.
     * If your code has an existing __autoload() function then this function must be explicitly registered on the __autoload queue.
     * This is because spl_autoload_register() will effectively replace the engine cache for the __autoload() function
     * by either spl_autoload() or spl_autoload_call()
     * return autoload
     */
    public static function getArgForConsoleParameters($argv){
        $list=[];
        foreach ($argv as $key=>$value){
            if($key>2){

                if(preg_match('@:@is',$value))
                {
                    $value=explode(":",$value);
                    $list[$value[0]]=$value[1];
                }
                else
                {
                    $list[$value]=$value;
                }
            }
        }

        return $list;

    }


    /**
     * Spl auto load register.
     * spl_autoload_register — Register given function as __autoload() implementation
     * Register a function with the spl provided __autoload queue. If the queue is not yet activated it will be activated.
     * If your code has an existing __autoload() function then this function must be explicitly registered on the __autoload queue.
     * This is because spl_autoload_register() will effectively replace the engine cache for the __autoload() function
     * by either spl_autoload() or spl_autoload_call()
     * return autoload
     */
    public static function getBaseConsoleStaticProperties($argv){
        //get connection
        if($argv[1]=="doctrine"){
            $consoleCommandApplication=new \lib\bin\doctrine();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        elseif($argv[1]=="system"){
            $consoleCommandApplication=new \lib\bin\system();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        elseif($argv[1]=="git"){
            $consoleCommandApplication=new \lib\bin\git();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        elseif($argv[1]=="list"){
            $consoleCommandApplication=new \lib\bin\apixlist();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }
        else{
            $consoleCommandApplication=new \lib\bin\custom();
            echo $consoleCommandApplication->execute($argv).''.PHP_EOL;
        }

    }
}