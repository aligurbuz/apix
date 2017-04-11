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
    public function getAll();

    /**
     * delete index.
     *
     */
    public function deleteIndex();
}