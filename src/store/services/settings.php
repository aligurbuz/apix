<?php
namespace Src\Store\Services;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Apix\StaticPathModel;

class Settings {

    public $optionalPath;
    public $settingsPath;

    public function __construct(){

        $this->optionalPath=StaticPathModel::optionalPath(true);
        $this->settingsPath=$this->optionalPath.'/Settings';

        if(!file_exists($this->settingsPath)){

            mkdir($this->settingsPath,0777);
            touch($this->settingsPath.'/app.dist');
        }

    }

    /**
     * @param $file string
     * @param $key
     * @param $value
     * @return string
     */
    public static function set($file, $key, $value){

        //get instance
        $instance=new self;

        //new data
        $new=[];
        $new[$key]=$value;

        /**
         * @var $old array
         */
        $old=(self::get($file)===null) ? [] : self::get($file);

        //join new data and old data
        $data=array_merge($old,$new);

        //yaml process
        $yaml = Yaml::dump($data);
        file_put_contents($instance->settingsPath.'/'.ucfirst($file).'.yml', $yaml);

    }

    /**
     * @param $file string
     * @param $default
     * @return string
     */
    public static function get($file,$default=null){

        //get instance
        $instance=new self;

        //file parse
        $fileParse=explode(".",$file);

        //get file
        $file=$fileParse[0];

        if(isset($fileParse[1])){

            //get key
            $key=$fileParse[1];
        }


        //get yaml path
        $yamlPath=$instance->settingsPath.'/'.$file.'.yml';

        if($default!==null){

            $value=(self::get($file)===null) ? [] : self::get($file);

            if(isset($key) AND !isset($value[$key])){
                return $default;
            }
        }

        //if there is no yaml path
        if(!file_exists($yamlPath)){

            return null;
        }


        //get yaml data
        $value = Yaml::parse(file_get_contents($yamlPath));

        if(isset($key)){

            //return with key
            return (isset($value[$key])) ? $value[$key] : null;
        }

        //all data
        return $value;

    }

    public static function has($file){

        return (self::get($file)===null) ? false : true;
    }

}
