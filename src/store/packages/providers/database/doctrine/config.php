<?php namespace src\store\packages\providers\database\doctrine;
use Apix\Utils;
use Src\Store\Config\App;

/**
 * Class Config
 * @package src\store\packages\providers\database\doctrine
 */
class Config {

    /**
     * @var array
     */
    public $paths = array("");
    /**
     * @var bool
     */
    public $isDevMode = false;
    /**
     * @var
     */
    public $dbParams;

    /**
     * @return array
     */
    public function dbParams(){

        $dbConfig=App::dbConfig();

        // the connection configuration
        return $this->dbParams = array(
            'driver'    => 'pdo_'.$dbConfig['driver'],
            'host'      => $dbConfig['host'],
            'user'      => $dbConfig['user'],
            'password'  => $dbConfig['password'],
            'dbname'    => $dbConfig['database'],
        );

    }


}