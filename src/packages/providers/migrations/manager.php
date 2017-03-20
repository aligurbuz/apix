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
    private $seed=false;
    private $seedValue=[];
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

        if(array_key_exists("--seed",$data)){
            $this->seed=true;
            if(is_array($data['--seed'])){
                $this->seedValue=$data['--seed'];
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
    public function getShowStatusLike(){
        $list=[];
        if(count($this->table)){
            foreach ($this->table as $key=>$table){
                $query=$this->db->prepare("SHOW TABLE STATUS LIKE '".$table."'");
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
    public function getShowIndexes(){
        $list=[];
        if(count($this->table)){
            foreach ($this->table as $key=>$table){
                $query=$this->db->prepare("SHOW INDEX FROM ".$table." WHERE Key_name!='PRIMARY'");
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
    public function getIndexInfo($table){
        $list=[];
        $query=$this->db->prepare("SHOW INDEX FROM ".$table." WHERE Key_name!='PRIMARY'");
        $query->execute();
        $result=$query->fetchAll(\PDO::FETCH_OBJ);
        foreach($result as $key=>$res){

            $list[$table]['Key_name'][]=$res->Key_name;
            $list[$table]['Column_name'][]=$res->Column_name;

        }
        return $list;
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getMultipleUniqueKeys($table,$field){
        $list=[];
        $query=$this->db->prepare("SHOW INDEXES FROM ".$table." WHERE Key_name='".$field."'");
        $query->execute();
        $result=$query->fetchAll(\PDO::FETCH_OBJ);
        foreach($result as $mul){
            $list[]=$mul->Column_name;
        }
        return $list;
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getAllUniqueKeys($table){
        $list=[];
        $query=$this->db->prepare("SHOW INDEXES FROM ".$table."");
        $query->execute();
        $result=$query->fetchAll(\PDO::FETCH_OBJ);
        foreach($result as $mul){
            $list[$mul->Key_name][]=$mul->Column_name;
        }
        return $list;
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getTables($listTables){
        $list=[];
        foreach($listTables as $key=>$data){
            $list[]=$key;
        }
        return $list;
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getFields($table){
        $list=[];
        $query=$this->db->prepare("SHOW COLUMNS FROM ".$table."");
        $query->execute();
        $result=$query->fetchAll(\PDO::FETCH_OBJ);
        foreach($result as $res){
            $list[]=$res->Field;
        }
        return $list;
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function seedTableForm($table){
        $list=[];
        $query=$this->db->prepare("select * from ".$table."");
        $query->execute();
        $result=$query->fetchAll(\PDO::FETCH_OBJ);
        if(count($result)){
            foreach ($result as $tune=>$res){
                foreach($this->getFields($table) as $key=>$value){
                    $list['execute'][$tune][]=$res->$value;
                    $list['prepare'][$tune][]='?';
                }
            }
        }

        return $list;

    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function seedFileProcess($table,$param=array(),$object){

        $executionPath=root."/lib/bin/commands/execution/migration_seed.php";
        $dt = fopen($executionPath, "r");
        $content = fread($dt, filesize($executionPath));
        fclose($dt);

        if(count($param)){
            foreach ($param as $key=>$value){

                $content=str_replace($key,$value,$content);
            }
        }

        $resultData=$this->seedTableForm($table);

        if(count($resultData)){

            $prepareList=[];
            foreach($resultData['prepare'] as $key=>$array){
                $prepareList[$key]=implode("@@",$array);
            }

            $executeList=[];
            foreach($resultData['execute'] as $key=>$array){
                $executeList[$key]=implode("@@",$array);
            }

            $content=str_replace('//prepare',implode("//",$prepareList),$content);
            $content=str_replace('//execute',implode("//",$executeList),$content);

            $dt = fopen(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/seeds//'.$table.'_seed.php', "w");
            fwrite($dt, $content);
            fclose($dt);

            echo '';
            echo '
            +++seed named '.$table.' has been created';
            echo '
            ';
        }



    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function seedProcess($listTables){
        if($this->seed){
            foreach($this->getTables($listTables) as $key=>$table){
                $this->seedFileProcess($table,[

                    '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\seeds',
                    '__classname__'=>$table.'_seed'
                ],[]);
            }
        }

    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function checkIfThereIsIndexes($table){
        $yaml=$this->getInfoYaml($table);
        $index=$this->getIndexInfo($table);


        if(count($yaml)){
            if((array_key_exists($table,$index) && array_key_exists("Key_name",$index[$table]))
                && (array_key_exists($table,$yaml[$table]['fields']) && array_key_exists("Key_name",$yaml[$table]['fields'][$table]))){

                foreach($yaml[$table]['fields'][$table]['Key_name'] as $uniqueVal){


                    if(!in_array($uniqueVal,$index[$table]['Key_name'])){

                        $file=new file();
                        $modelFile='__'.time().'__'.$table.'';
                        $path=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas';
                        $file->touch($path.'/'.$table.'/'.$modelFile.'.php');
                        $this->fileProcessIndex($table,[

                            '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\schemas\\'.$table,
                            '__classname__'=>$modelFile
                        ],['deleteIndex'=>$uniqueVal]);
                    }
                }
            }

        }



    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function pull($listTables){

        $this->seedProcess($listTables);
        $file=new file();
        $time=time();
        if(count($listTables)){
            $path=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas';
            foreach($listTables as $key=>$object){
                if(!$file->exists($path.'/'.$key.'')){
                    $file->mkdir($path,$key);
                }

                $this->checkIfThereIsIndexes($key);
                $writeInfo=$this->writeInfo($key,$object);


                if($writeInfo['status']=="first"){
                    $modelFile='__'.$time.'__'.$key.'';
                    $file->touch($path.'/'.$key.'/'.$modelFile.'.php');
                    $this->fileProcess($key,[

                        '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\schemas\\'.$key,
                        '__classname__'=>$modelFile
                    ],$object);
                }
                if($writeInfo['status']=="noupdate"){
                    echo '';
                    echo '
                    ---'.$key.' table does not have updating information';
                    echo '
                    ';
                }

                if($writeInfo['status']=="update"){

                    if(array_key_exists("diff",$writeInfo['data'])){
                        $updateData=[];
                        foreach ($writeInfo['data']['diff']['beforeField'] as $okey=>$ovalue){
                            $time=time()+$okey+1;
                            $updateData['diff']['beforeField']=$ovalue;
                            $updateData['diff']['Field']=$writeInfo['data']['diff']['Field'][$okey];
                            $updateData['diff']['Type']=$writeInfo['data']['diff']['Type'][$okey];
                            $updateData['diff']['Null']=$writeInfo['data']['diff']['Null'][$okey];
                            $updateData['diff']['Key']=$writeInfo['data']['diff']['Key'][$okey];
                            $updateData['diff']['Default']=$writeInfo['data']['diff']['Default'][$okey];
                            $updateData['diff']['Extra']=$writeInfo['data']['diff']['Extra'][$okey];
                            $modelFile='__'.$time.'__'.$key.'';
                            $file->touch($path.'/'.$key.'/'.$modelFile.'.php');
                            $this->fileProcessUpdate($key,[

                                '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\schemas\\'.$key,
                                '__classname__'=>$modelFile
                            ],$updateData);
                        }
                    }

                    if(array_key_exists("change",$writeInfo['data'])){

                        $updateData=[];
                        foreach ($writeInfo['data']['change']['beforeField'] as $okey=>$ovalue){
                            $time=time()+$okey+2;
                            $updateData['change']['beforeField']=$ovalue;
                            $updateData['change']['Field']=$writeInfo['data']['change']['Field'][$okey];
                            $updateData['change']['Type']=$writeInfo['data']['change']['Type'][$okey];
                            $updateData['change']['Null']=$writeInfo['data']['change']['Null'][$okey];
                            $updateData['change']['Key']=$writeInfo['data']['change']['Key'][$okey];
                            $updateData['change']['Default']=$writeInfo['data']['change']['Default'][$okey];
                            $updateData['change']['Extra']=$writeInfo['data']['change']['Extra'][$okey];
                            $modelFile='__'.$time.'__'.$key.'';
                            $file->touch($path.'/'.$key.'/'.$modelFile.'.php');
                            $this->fileProcessUpdate($key,[

                                '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\schemas\\'.$key,
                                '__classname__'=>$modelFile
                            ],$updateData);
                        }

                    }

                    if(array_key_exists("changeField",$writeInfo['data'])){

                        $updateData=[];
                        foreach ($writeInfo['data']['changeField']['Field']['old'] as $okey=>$ovalue){
                            $time=time()+$okey+3;
                            $updateData['changeField']['old']=$ovalue;
                            $updateData['changeField']['new']=$writeInfo['data']['changeField']['Field']['new'][$okey];
                            $updateData['changeField']['Type']=$writeInfo['data']['changeField']['Type'][$okey];
                            $updateData['changeField']['Null']=$writeInfo['data']['changeField']['Null'][$okey];
                            $updateData['changeField']['Key']=$writeInfo['data']['changeField']['Key'][$okey];
                            $updateData['changeField']['Default']=$writeInfo['data']['changeField']['Default'][$okey];
                            $updateData['changeField']['Extra']=$writeInfo['data']['changeField']['Extra'][$okey];

                            $modelFile='__'.$time.'__'.$key.'';
                            $file->touch($path.'/'.$key.'/'.$modelFile.'.php');
                            $this->fileProcessUpdate($key,[

                                '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\schemas\\'.$key,
                                '__classname__'=>$modelFile
                            ],$updateData);
                        }

                    }
                    if(array_key_exists("dropField",$writeInfo['data'])){

                        foreach($writeInfo['data']['dropField']['Field'] as $okey=>$oval){
                            $time=time()+$okey+4;
                            $updateData['dropField']['Field']=$writeInfo['data']['dropField']['Field'][$okey];

                            $modelFile='__'.$time.'__'.$key.'';
                            $file->touch($path.'/'.$key.'/'.$modelFile.'.php');
                            $this->fileProcessUpdate($key,[

                                '__namespace__'=>'src\\app\\'.$this->project.'\\'.$this->version.'\\migrations\\schemas\\'.$key,
                                '__classname__'=>$modelFile
                            ],$updateData);

                            $migrationYaml=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/migration.yaml';
                            if(file_exists($migrationYaml)){
                                $yaml = Yaml::parse(file_get_contents(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/migration.yaml'));
                                $yaml['migration'][]=$modelFile.'.php';

                                $yaml = Yaml::dump($yaml);

                                file_put_contents($migrationYaml, $yaml);
                            }
                            else{
                                $yaml = Yaml::dump(['migration'=>[''.$modelFile.'.php']]);

                                file_put_contents($migrationYaml, $yaml);

                            }
                        }

                    }


                }

            }
        }

    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function writeInfo($table,$data){
        $yaml=$this->getInfoYaml($table);

        $hash=md5(json_encode($this->getFieldsFromDb($data)));

        if((array_key_exists($table,$yaml) AND array_key_exists('hash',$yaml[$table])) AND $yaml[$table]['hash']==$hash){
            return ['status'=>'noupdate'];
        }

        if((array_key_exists($table,$yaml) AND array_key_exists('hash',$yaml[$table])) AND $yaml[$table]['hash']!==$hash){
            $update=$this->updateInfoYaml($table,[$table=>['hash'=>$hash,'fields'=>$this->getFieldsFromDb($data)]],$data);
            if($update['yamlStatus']){
                return ['status'=>'update','data'=>$update['data']];
            }
            return ['status'=>'noupdate'];
        }

        if($this->setInfoYaml($table,[$table=>['hash'=>$hash,'fields'=>$this->getFieldsFromDb($data)+$this->getIndexInfo($table)]])){
            return ['status'=>'first'];
        }

    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getFieldsFromDb($data){
        $list=[];
        foreach($data as $key=>$object){
            $list['Field'][]=$data[$key]->Field;
            $list['Type'][]=$data[$key]->Type;
            $list['Null'][]=$data[$key]->Null;
            $list['Key'][]=$data[$key]->Key;
            $list['Default'][]=$data[$key]->Default;
            $list['Extra'][]=$data[$key]->Extra;
        }
        return $list;
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function getInfoYaml($table){
        $migrationYaml=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/info.yaml';
        if(file_exists($migrationYaml)){
            $yaml = Yaml::parse(file_get_contents(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/info.yaml'));
        }
        else{
            $yaml = Yaml::dump([]);
            file_put_contents($migrationYaml, $yaml);
            $yaml = Yaml::parse(file_get_contents(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/info.yaml'));
        }

        return $yaml;
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function setInfoYaml($table,$dump){

        $yaml = Yaml::dump($dump);
        return file_put_contents(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/info.yaml', $yaml);
    }

    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function updateInfoYaml($table,$dump,$data){
        $yaml=$this->getInfoYaml($table);
        $listVal=[];
        foreach($dump[$table]['fields']['Field'] as $key=>$value){
            if(count($dump[$table]['fields']['Field'])!==count($yaml[$table]['fields']['Field']) && !in_array($value,$yaml[$table]['fields']['Field'])){
                foreach($data as $datakey=>$object){
                    if($data[$datakey]->Field==$value){
                        $beforeKey=$datakey-1;
                        $listVal['diff']['beforeField'][]=$data[$beforeKey]->Field;
                        $listVal['diff']['Field'][]=$data[$datakey]->Field;
                        $listVal['diff']['Type'][]=$data[$datakey]->Type;
                        $listVal['diff']['Null'][]=$data[$datakey]->Null;
                        $listVal['diff']['Key'][]=$data[$datakey]->Key;
                        $listVal['diff']['Default'][]=$data[$datakey]->Default;
                        $listVal['diff']['Extra'][]=$data[$datakey]->Extra;
                    }
                }
            }
            else {
                if(
                    $yaml[$table]['fields']['Type'][$key]!==$dump[$table]['fields']['Type'][$key] OR
                    $yaml[$table]['fields']['Null'][$key]!==$dump[$table]['fields']['Null'][$key] OR
                    $yaml[$table]['fields']['Key'][$key]!==$dump[$table]['fields']['Key'][$key] OR
                    $yaml[$table]['fields']['Default'][$key]!==$dump[$table]['fields']['Default'][$key] OR
                    $yaml[$table]['fields']['Extra'][$key]!==$dump[$table]['fields']['Extra'][$key]
                ){

                    foreach($data as $datakey=>$object){
                        if($data[$datakey]->Field==$yaml[$table]['fields']['Field'][$key]){
                            $beforeKey=$datakey-1;
                            $listVal['change']['beforeField'][]=$data[$beforeKey]->Field;
                            $listVal['change']['Field'][]=$data[$datakey]->Field;
                            $listVal['change']['Type'][]=$data[$datakey]->Type;
                            $listVal['change']['Null'][]=$data[$datakey]->Null;
                            $listVal['change']['Key'][]=$data[$datakey]->Key;
                            $listVal['change']['Default'][]=$data[$datakey]->Default;
                            $listVal['change']['Extra'][]=$data[$datakey]->Extra;
                        }

                    }

                }
            }


        }


        //drop field
        foreach($yaml[$table]['fields']['Field'] as $key=>$value) {
            if (count($yaml[$table]['fields']['Field'])!==count($dump[$table]['fields']['Field']) AND !in_array($value, $dump[$table]['fields']['Field'])) {
                $listVal['dropField']['Field'][]=$value;
            }
            else{

                if($dump[$table]['fields']['Field'][$key]!==$value){

                    $listVal['changeField']['Field']['old'][]=$value;
                    $listVal['changeField']['Field']['new'][]=$dump[$table]['fields']['Field'][$key];
                    $listVal['changeField']['Type'][]=$dump[$table]['fields']['Type'][$key];
                    $listVal['changeField']['Null'][]=$dump[$table]['fields']['Null'][$key];
                    $listVal['changeField']['Key'][]=$dump[$table]['fields']['Key'][$key];
                    $listVal['changeField']['Default'][]=$dump[$table]['fields']['Default'][$key];
                    $listVal['changeField']['Extra'][]=$dump[$table]['fields']['Extra'][$key];
                }

            }
        }

        $yaml = Yaml::dump($dump);
        return ['yamlStatus'=>file_put_contents(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/info.yaml', $yaml),'data'=>$listVal];
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

                $migrationYaml=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/migration.yaml';
                if(file_exists($migrationYaml)){
                    $yaml = Yaml::parse(file_get_contents(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/migration.yaml'));
                }
                else{
                    $yaml = Yaml::dump(['migration'=>[]]);

                    file_put_contents($migrationYaml, $yaml);

                    $yaml = Yaml::parse(file_get_contents(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/migration.yaml'));
                }


                if(!in_array($key,$yaml['migration'])){
                    try {

                        $query=$this->db->prepare($value);
                        $query->execute();

                        $yaml['migration'][]=$key;

                        $yaml = Yaml::dump($yaml);

                        file_put_contents($migrationYaml, $yaml);

                        echo '
                        ';
                        echo '++++'.$table.' migration has been completed as push';
                        echo '
                        ';

                        if($this->seed){
                            $seedFile=root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/seeds/'.$table.'_seed.php';
                            if(file_exists($seedFile)){
                                $seedNameSpace="\\src\\app\\".$this->project."\\".$this->version."\\migrations\\seeds\\".$table."_seed";
                                $result=$seedNameSpace::up();
                                if($result['prepare']!=="//prepare"){
                                    $prepareList=explode("//",$result['prepare']);
                                    $executeList=explode("//",$result['execute']);

                                    foreach($prepareList as $pkey=>$pvalue){
                                        $resultPrepare=explode("@@",$pvalue);
                                        $query=$this->db->prepare("INSERT INTO ".$table." VALUES (".implode(",",$resultPrepare).")");
                                        $resultExecute=explode("@@",$executeList[$pkey]);
                                        if($query->execute($resultExecute)) {
                                            echo '
                                            ';
                                            echo '+++' . $table . ' seed has beed completed as push';
                                            echo '
                                            ';
                                        }
                                    }

                                }

                            }
                        }

                    }
                    catch(\Exception $e){

                        echo '';
                        echo '---'.$table.' :'.$e->getMessage();
                        echo '
                        ';
                    }
                }

                else{

                    echo '
                    ';
                    echo '!!!!'.$table.' ['.$key.'] : has once migration';
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
                $list[$table][$value]=$schemaNameSpacePath::up();
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

        echo '';
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
    public function fileProcessUpdate($table,$param=array(),$object){
        $executionPath=root."/lib/bin/commands/execution/migration.php";
        $dt = fopen($executionPath, "r");
        $content = fread($dt, filesize($executionPath));
        fclose($dt);

        if(count($param)){
            foreach ($param as $key=>$value){

                $content=str_replace($key,$value,$content);
            }
        }

        $content=str_replace('//data',$this->tableFormUpdate($object,$table),$content);

        $dt = fopen(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/'.$param['__classname__'].'.php', "w");
        fwrite($dt, $content);
        fclose($dt);

        echo '
        ';
        echo '+++migration named '.$table.' has been created';
        echo '
        ';
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function fileProcessIndex($table,$param=array(),$object){
        $executionPath=root."/lib/bin/commands/execution/migration.php";
        $dt = fopen($executionPath, "r");
        $content = fread($dt, filesize($executionPath));
        fclose($dt);

        if(count($param)){
            foreach ($param as $key=>$value){

                $content=str_replace($key,$value,$content);
            }
        }

        $content=str_replace('//data',$this->tableFormDeleteIndex($object,$table),$content);

        $dt = fopen(root.'/src/app/'.$this->project.'/'.$this->version.'/migrations/schemas/'.$table.'/'.$param['__classname__'].'.php', "w");
        fwrite($dt, $content);
        fclose($dt);

        echo '
        ';
        echo '+++migration named '.$table.' has been created';
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
        $statusLike=$this->getShowStatusLike();
        $indexes=$this->getShowIndexes();

        $index=[];
        $indexKeys=[];
        $uniqueKeys=[];
        if(count($indexes[$table])){
            foreach ($indexes[$table] as $key=>$val){
                if($indexes[$table][$key]->Non_unique>0){
                    $indexKeys[$indexes[$table][$key]->Key_name][]=$indexes[$table][$key]->Column_name;
                }
                else{
                    $uniqueKeys[$indexes[$table][$key]->Key_name][]=$indexes[$table][$key]->Column_name;
                }

            }
            foreach ($indexKeys as $keyName=>$array){
                $index[]='KEY '.$keyName.' ('.implode(",",$array).')';
            }
        }

        $unique='';
        $indexExtension=null;
        if(count($index)){
            $indexExtension=(count($index)) ? ','.implode(",",$index).'' : '';
        }


        foreach ($object as $key=>$data){
            if($object[$key]->Null=="NO"){
                if($object[$key]->Default!==NULL){
                    $null='DEFAULT \"'.$object[$key]->Default.'\"';
                }
                else{
                    $null='NOT NULL';
                }
            }
            else{
                if($object[$key]->Default!==NULL){
                    $null='DEFAULT \"'.$object[$key]->Default.'\"';
                }
                else{
                    $null='NULL';
                }

            }

            if($object[$key]->Extra=="auto_increment"){
                $extension='AUTO_INCREMENT PRIMARY KEY';
            }
            else{
                $extension='';
            }

            if($object[$key]->Key=="UNI"){
                $unique=',UNIQUE KEY '.$object[$key]->Field.' ('.$object[$key]->Field.')';
                $indexExtension='';
            }
            if($object[$key]->Key=="MUL"){
                if(array_key_exists($object[$key]->Field,$uniqueKeys) && count($uniqueKeys[$object[$key]->Field])){
                    $unique=',UNIQUE KEY '.$object[$key]->Field.' ('.implode(",",$uniqueKeys[$object[$key]->Field]).')';
                }
            }


           $list[]=''.$object[$key]->Field.' '.$object[$key]->Type.' '.$null.' '.$extension.'' ;
        }


        if(count($list)){

            return 'CREATE TABLE IF NOT EXISTS '.$table.' (
            '.implode(",
            ",$list).'
            '.$indexExtension.'
            '.$unique.'
            ) ENGINE='.$statusLike[$table][0]->Engine.' DEFAULT COLLATE='.$statusLike[$table][0]->Collation.' AUTO_INCREMENT=1 ;';
        }
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function tableFormDeleteIndex($object,$table){
        return 'ALTER TABLE '.$table.' DROP INDEX '.$object['deleteIndex'].'';
    }


    /**
     * engine method is main method.
     *
     * @return class object
     */
    public function tableFormUpdate($object,$table){

        if(array_key_exists("diff",$object)){

            if($object['diff']['Null']=="NO"){
                if($object['diff']['Default']!==NULL){
                    $null='DEFAULT \"'.$object['diff']['Default'].'\"';
                }
                else{
                    $null='NOT NULL';
                }
            }
            else{
                if($object['diff']['Default']!==NULL){
                    $null='DEFAULT \"'.$object['diff']['Default'].'\"';
                }
                else{
                    $null='NULL';
                }

            }




            if($object['diff']['Key']=="UNI"){
                $unique=',ADD UNIQUE ('.$object['diff']['Field'].')';
            }
            else{
                $unique='';
            }


            $indexes=$this->getShowIndexes();
            $indexList=[];
            foreach ($indexes[$table] as $key=>$value){
                if($indexes[$table][$key]->Key_name==$object['diff']['Field']){
                    if($indexes[$table][$key]->Non_unique>0){
                        $indexList[$object['diff']['Field']][]=$indexes[$table][$key]->Column_name;
                    }
                }
            }

            $mul=$this->getMultipleUniqueKeys($table,$object['diff']['Field']);

            if($object['diff']['Field']==end($mul) && $object['diff']['Key']=="MUL"){

                if(count($indexList)){
                    $unique=',ADD INDEX '.$object['diff']['Field'].' ('.implode(",",$indexList[$object['diff']['Field']]).')';
                }
                else{
                    $unique=',ADD UNIQUE '.$object['diff']['Field'].' ('.implode(",",$this->getMultipleUniqueKeys($table,$object['diff']['Field'])).')';
                }

            }
            else{



                $mul=$this->getAllUniqueKeys($table);
                $mulList=[];
                foreach($mul as $key_name=>$array){
                    if(in_array($object['diff']['Field'],$array) && $key_name!==$object['diff']['Field']){
                        $mulList[$key_name]=$array;
                    }
                }

                foreach($mulList as $key_name=>$array){
                    if($object['diff']['Field']==end($mulList[$key_name])){

                        $indexes=$this->getShowIndexes();
                        $indexList=[];
                        foreach ($indexes[$table] as $key=>$value){
                            if($indexes[$table][$key]->Key_name==$key_name){
                                if($indexes[$table][$key]->Non_unique>0){
                                    $indexList[$key_name][]=$indexes[$table][$key]->Column_name;
                                }
                            }
                        }

                        if(count($indexList)){
                            $unique=',ADD INDEX '.$key_name.' ('.implode(",",$indexList[$key_name]).')';
                        }
                        else{
                            $unique=',ADD UNIQUE '.$key_name.' ('.implode(",",$mulList[$key_name]).')';
                        }

                    }

                }
            }


            return 'ALTER TABLE '.$table.' ADD '.$object['diff']['Field'].' '.$object['diff']['Type'].' '.$null.' AFTER '.$object['diff']['beforeField'].' '.$unique;
        }

        if(array_key_exists("dropField",$object)){
            return 'ALTER TABLE '.$table.'  DROP  '.$object['dropField']['Field'].'';
        }

        if(array_key_exists("change",$object)){

            if($object['change']['Null']=="NO"){
                if($object['change']['Default']!==NULL){
                    $null='DEFAULT \"'.$object['change']['Default'].'\"';
                }
                else{
                    $null='NOT NULL';
                }
            }
            else{
                if($object['change']['Default']!==NULL){
                    $null='DEFAULT \"'.$object['change']['Default'].'\"';
                }
                else{
                    $null='NULL';
                }

            }

            if($object['change']['Key']=="UNI"){
                $unique=',ADD UNIQUE ('.$object['change']['Field'].')';
            }
            else{
                $unique='';
            }

            if($object['change']['Key']=="MUL"){

                $indexes=$this->getShowIndexes();
                $indexList=[];
                foreach ($indexes[$table] as $key=>$value){
                    if($indexes[$table][$key]->Key_name==$object['change']['Field']){
                        if($indexes[$table][$key]->Non_unique>0){
                            $indexList[$object['change']['Field']][]=$indexes[$table][$key]->Column_name;
                        }
                    }
                }

                if(count($indexList)){
                    $unique=',ADD INDEX '.$object['change']['Field'].' ('.implode(",",$indexList[$object['change']['Field']]).')';
                }
                else{
                    $unique=',ADD UNIQUE '.$object['change']['Field'].' ('.implode(",",$this->getMultipleUniqueKeys($table,$object['change']['Field'])).')';
                }


            }

            return 'ALTER TABLE  '.$table.' CHANGE  '.$object['change']['Field'].'  '.$object['change']['Field'].' '.$object['change']['Type'].' '.$null.' '.$unique.'  ';
        }


        if(array_key_exists("changeField",$object)){

            if($object['changeField']['Null']=="NO"){
                if($object['changeField']['Default']!==NULL){
                    $null='DEFAULT \"'.$object['changeField']['Default'].'\"';
                }
                else{
                    $null='NOT NULL';
                }
            }
            else{
                if($object['changeField']['Default']!==NULL){
                    $null='DEFAULT \"'.$object['changeField']['Default'].'\"';
                }
                else{
                    $null='NULL';
                }

            }

            if($object['changeField']['Key']=="UNI"){
                $unique=',ADD UNIQUE ('.$object['changeField']['Field'].')';
            }
            else{
                $unique='';
            }

            if($object['changeField']['Key']=="MUL"){

                $indexes=$this->getShowIndexes();
                $indexList=[];
                foreach ($indexes[$table] as $key=>$value){
                    if($indexes[$table][$key]->Key_name==$object['changeField']['new']){
                        if($indexes[$table][$key]->Non_unique>0){
                            $indexList[$object['changeField']['new']][]=$indexes[$table][$key]->Column_name;
                        }
                    }
                }

                if(count($indexList)){
                    $unique=',ADD INDEX '.$object['changeField']['new'].' ('.implode(",",$indexList[$object['changeField']['new']]).')';
                }
                else{
                    $unique=',ADD UNIQUE '.$object['changeField']['new'].' ('.implode(",",$this->getMultipleUniqueKeys($table,$object['changeField']['new'])).')';
                }

            }
            return 'ALTER TABLE  '.$table.' CHANGE  '.$object['changeField']['old'].'  '.$object['changeField']['new'].' '.$object['changeField']['Type'].' '.$null.' '.$unique.' ';
        }

    }

}