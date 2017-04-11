<?php
namespace src\store\packages\providers\search;

// Declare the interface 'search engine'
interface searchInterface
{
    /**
     * search ping method.
     * test start
     *
     */
    public function ping();

    /**
     * get all index and types.
     * getAll
     *
     */
    public function getAll($data=array());

    /**
     * delete index.
     *
     */
    public function deleteIndex($index=null);

    /**
     * set Map.
     *
     */
    public function setMap($data=array());
}