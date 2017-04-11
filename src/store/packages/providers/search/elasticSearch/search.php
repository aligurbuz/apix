<?php
/*
 * This is the official PHP client for Elasticsearch. It is designed to be a very low-level client that does not stray from the REST API.
 * All methods closely match the REST API, and furthermore, match the method structure of other language clients (ruby, python, etc).
 * We hope that this consistency makes it easy to get started with a client, and to seamlessly switch from one language to the next with minimal effort.
 * The client is designed to be "unopinionated". There are a few universal niceties added to the client (cluster state sniffing,
 * round-robin requests, etc) but largely it is very barebones. This was intentional. We want a common base that more sophisticated libraries can build on top of.
 */

namespace src\store\packages\providers\search\elasticSearch;
use src\store\packages\providers\search\searchInterface;

/**
 * Represents a elastic search class.
 *
 * main call
 * return type string
 */

class search implements searchInterface {

    public $client;

    /**
     * elastic search class.
     *
     */
    public function __construct(){

        //search client
        $this->client=\Elasticsearch\ClientBuilder::create()->build();
    }

    /**
     * elastic search ping.
     * test start
     *
     */
    public function ping(){

        //search ping
        return 'ping';
    }

    /**
     * elastic search getAll.
     * The Get Mappings API will return the mapping details about your indexes and types.
     * Depending on the mappings that you wish to retrieve, you can specify a number of combinations of index and type:
     * @return array
     */
    public function getAll($params=array())
    {
        return $this->client->indices()->getMapping($params);
    }

}
