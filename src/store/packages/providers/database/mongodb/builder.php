<?php
/*
 * The MongoDB PHP Library provides a high-level abstraction around the
 * lower-level PHP driver, also known as the mongodb extension.
 *
 * While the mongodb extension provides a limited API for executing commands, queries, and write
 * operations, the MongoDB PHP Library implements an API similar to that of the legacy PHP driver.
 * The library contains abstractions for client, database, and collection objects, and provides methods for
 * CRUD operations and common commands such as index and collection management.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\packages\providers\database\mongodb;

/**
 * Represents a mongodb class.
 *
 * main mongodb
 * return type mixed
 */

class builder {

    /**
     * @var $connection
     * connection to mongodb
     */
    public $connection;

    /**
     * @var $collection
     * alias document
     */
    public $collection;


    public function __construct($database){

        $this->connection=(new \MongoDB\Client)->$database;
    }

    public function collection($collection=null){

        if($collection===null){
            throw new \InvalidArgumentException('document as table is not available');
        }

        $this->collection=$this->connection->$collection;

        return $this;
    }

    public function get(){

        $data = $this->collection->find()->toArray();
        return $this->resolve($data);
    }

    private function resolve($data){

        $dataArray=json_decode(json_encode($data),1);
        $list=[];
        foreach($dataArray as $key=>$value){
            foreach($value as $column=>$columnValue){

                if($column=="_id"){
                    $column='id';
                    $columnValue=$dataArray[$key]['_id']['$oid'];
                }

                $list[$key][$column]=$columnValue;
            }
        }

        return $list;
    }

}