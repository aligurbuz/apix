<?php

namespace src\store\config;

class dbConnector {

    private static $instance=null;
    private $driver;
    private $host;
    private $database;
    private $user;
    private $password;
    private $db=null;

    /**
     * @param bool $status
     */
    public function __construct ($status=false,$app=null,$version=null){

        if($status){

            if($app!==null && $version!==null){
                $app=$app;
                $version=$version;
            }
            else{
                $app=app;
                $version=version;

            }

            $config="\\src\\app\\".$app."\\".$version."\\config\\database";
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
                    //$this->db->setAttribute(\PDO::ATTR_PERSISTENT,true);

                    self::$instance=$this->db;
                }

                $this->db=self::$instance;
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

    }


    public function get(){

        return $this->db;

    }

    public function getDriver(){
        return $this->driver;
    }
}
