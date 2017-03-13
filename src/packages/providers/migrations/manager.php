<?php
/*
 * This file is main part of the search.
 *
 * model is called for search file as default
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\packages\providers\migrations;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use src\services\fileProcess as file;

/**
 * Represents a search class.
 *
 * main call
 * return type array
 */

class manager {

    private $project=null;
    private $model=null;
    private $db=null;
    private $driver=null;
    private $host=null;
    private $database=null;
    private $user=null;
    private $password=null;
    private $table=array();
    private $migration=null;
    private static $instance=null;
    /**
     * get construct.
     *
     */
    public function __construct($data){
        $this->project=$data['project'];
        if(array_key_exists("model",$data)){
            $this->model=$data['model'];
        }
        if(array_key_exists("version",$data)){
            $this->version=$data['version'];
        }
        else{
            $version=require(root.'/src/app/'.$this->project.'/version.php');
            if(is_array($version)){
                $this->version=$version['version'];
            }
        }

        $this->migration=$data['migration'];

        define("app",$this->project);

        //check environment
        \lib\environment::config();

        if($this->model!==null){
            $model="\\src\\app\\".$this->project."\\".$this->version."\\model\\".$this->model;
            $model=new $model();
            $this->table[]=$model->table;
        }
        else{
            foreach (glob(root."/src/app/".$this->project."/".$this->version."/model/*.php") as $filename) {
                $filename=str_replace(root."/src/app/".$this->project."/".$this->version."/model/","",$filename);
                $filename=str_replace(".php","",$filename);
                $model="\\src\\app\\".$this->project."\\".$this->version."\\model\\".$filename;
                $model=new $model();
                $this->table[]=$model->table;
            }
        }


        $config="\\src\\app\\".$this->project."\\".$this->version."\\config\\database";
        $configdb=$config::dbsettings();

        $this->driver=$configdb['driver'];
        $this->host=$configdb['host'];
        $this->database=$configdb['database'];
        $this->user=$configdb['user'];
        $this->password=$configdb['password'];


        /** @var TYPE_NAME $this */
        try {

            if(self::$instance===null){
                $this->db = new \PDO(''.$this->driver.':host='.$this->host.';dbname='.$this->database.'', $this->user,$this->password);
                $this->db->exec("SET NAMES utf8");
                $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->db->setAttribute(\PDO::ATTR_EMULATE_PREPARES,false);
                $this->db->setAttribute(\PDO::ATTR_PERSISTENT,true);
            }
        }
        catch (\PDOException $e) {
            if(environment()=="local"){
                $connectionError=[
                    'status'=>false,
                    'result'=>[
                        'error'=>true,
                        'code'=>$e->getCode(),
                        'message'=>'Database Connection Error',
                        'trace'=>$e->getTrace()
                    ]

                ];
                echo json_encode($connectionError);
            }
            else{
                $connectionError=[
                    'status'=>false,
                    'result'=>[
                        'error'=>true,
                        'message'=>'Error occured'
                    ]

                ];
                echo json_encode($connectionError);
            }

            exit();
        }
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function handle(){

        $migration=$this->migration;
        $param=($migration=="push") ? [] : $this->getShowColumns();
        return $this->$migration($param);
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getShowColumns(){
        $list=[];
        if(count($this->table)){
            foreach ($this->table as $key=>$table){
                $query=$this->db->prepare("SHOW COLUMNS FROM ".$table."");
                $query->execute();
                $result=$query->fetchAll(\PDO::FETCH_OBJ);
                $list[$table]=$result;
            }
        }
        return $list;
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function pull($listTables){
        $file=new file();
        $time=time();
        if(count($listTables)){
            $path=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas';
            foreach($listTables as $key=>$object){
                if(!$file->exists($path.'/'.$key.'')){
                    $file->mkdir($path,$key);
                }
                $modelFile='__'.$time.'__'.$key.'';
                $file->touch($path.'/'.$key.'/'.$modelFile.'.php');
                $this->fileProcess($key,[

                        '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\schemas\\'.$key,
                        '__classname__'=>$modelFile
                ],$object);
            }
        }

    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function push($listTables){
        $schemasSql=$this->getUpSchemaHandle($this->getSchemas());
        foreach($this->table as $table){
            foreach($schemasSql[$table] as $key=>$value){

                try {

                    $query=$this->db->prepare($value);
                    $query->execute();

                    echo '
                            ++++'.$table.' migration has been completed as push';
                    echo '
                    ';
                }
                catch(\Exception $e){

                    echo '
                            ++++'.$table.' :'.$e->getMessage();
                    echo '
                    ';
                }


            }
        }

    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getSchemas(){
        $list=[];
        foreach($this->table as $key=>$table){
            $schemasTablePath=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'';
            foreach (glob("".$schemasTablePath."/*.php") as $filename) {
                $filename=explode("/",$filename);
                $list[$table][]=end($filename);
            }
        }

        return $list;

    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getUpSchemaHandle($class){
        $list=[];
        foreach ($class as $table=>$data){
            foreach($class[$table] as $key=>$value){
                $schemaNameSpacePath="\\src\\app\\mobi\\v1\\migrations\\schemas\\".$table."\\".str_replace(".php","",$value);
                $list[$table][]=$schemaNameSpacePath::up();
            }
        }

        return $list;


    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function fileProcess($table,$param=array(),$object){
        $executionPath=root."/lib/bin/commands/execution/migration.php";
        $dt = fopen($executionPath, "r");
        $content = fread($dt, filesize($executionPath));
        fclose($dt);

        if(count($param)){
            foreach ($param as $key=>$value){

                $content=str_replace($key,$value,$content);
            }
        }

        $content=str_replace('//data',$this->tableForm($object,$table),$content);

        $dt = fopen(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/'.$param['__classname__'].'.php', "w");
        fwrite($dt, $content);
        fclose($dt);

        echo '
        +++migration named '.$table.' has been created';
        echo '
        ';
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function tableForm($object,$table){
        $list=[];

        foreach ($object as $key=>$data){
            if($object[$key]->Null=="NO"){
                $null='NOT NULL';
            }
            else{
                $null='NULL';
            }

            if($object[$key]->Extra=="auto_increment"){
                $extension='AUTO_INCREMENT PRIMARY KEY';
            }
            else{
                $extension='';
            }
           $list[]=''.$object[$key]->Field.' '.$object[$key]->Type.' '.$null.' '.$extension.'' ;
        }


        if(count($list)){

            return 'CREATE TABLE IF NOT EXISTS '.$table.' (
            '.implode(",
            ",$list).'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
        }
    }

}