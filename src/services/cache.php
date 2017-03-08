<?php
/*
 * This file make data cache for every service
 *
 * cache | symfony cache
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\services;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Cache\Adapter\ProxyAdapter;

/**
 * Represents a cache class.
 *
 * main call
 * return type string
 */

class cache {

    private $adapter='file';
    private $fileExpire=60;
    private $cache=null;

    public function __construct(){
        $adapterMethod=$this->adapter.'CacheAdapter';
        $this->$adapterMethod();
    }


    /**
     * cache get data.
     *
     * @return cache class
     */
    public function get($name,$callback)
    {
        //get Item
        $name='cache.'.$name.'';
        $nameSet=$this->cache->getItem($name);

        //check is hit
        if (!$nameSet->isHit()) {
            // ... item does not exists in the cache
            $data=call_user_func($callback);
            $nameSet->set($data);
            $this->cache->save($nameSet);
            return call_user_func($callback);
        }
        return $nameSet->get();

    }


    /**
     * file cache adapter.
     *
     * @return file adapter class
     */
    public function fileCacheAdapter()
    {
        $this->cache = new FilesystemAdapter(
        // the subdirectory of the main cache directory where cache items are stored
            $namespace = '',
            // in seconds; applied to cache items that don't define their own lifetime
            // 0 means to store the cache items indefinitely (i.e. until the files are deleted)
            $defaultLifetime = $this->fileExpire,
            // the main cache directory (the application needs read-write permissions on it)
            // if none is specified, a directory is created inside the system temporary directory
            $directory = application.'/'.version.'/__call/'.service.'/cache'
        );
    }


    /**
     * php file cache adapter.
     *
     * @return php file adapter class
     */
    public function phpCacheAdapter()
    {
        $this->cache = new PhpFilesAdapter(
        // the subdirectory of the main cache directory where cache items are stored
            $namespace = '',
            // in seconds; applied to cache items that don't define their own lifetime
            // 0 means to store the cache items indefinitely (i.e. until the files are deleted)
            $defaultLifetime = $this->fileExpire,
            // the main cache directory (the application needs read-write permissions on it)
            // if none is specified, a directory is created inside the system temporary directory
            $directory = application.'/'.version.'/__call/'.service.'/cache'
        );
    }


    /**
     * redis cache adapter.
     *
     * @return redis adapter class
     */
    public function redisCacheAdapter()
    {
        $this->cache = new RedisAdapter(

            // the subdirectory of the main cache directory where cache items are stored
            $namespace = '',
            // in seconds; applied to cache items that don't define their own lifetime
            // 0 means to store the cache items indefinitely (i.e. until the files are deleted)
            $defaultLifetime = $this->fileExpire,
            // the main cache directory (the application needs read-write permissions on it)
            // if none is specified, a directory is created inside the system temporary directory
            $directory = application.'/'.version.'/__call/'.service.'/cache'
        );

        //The createConnection() helper allows creating a connection to a Redis server using a DSN configuration:
        $redisConnection = RedisAdapter::createConnection('redis://localhost');
    }



}
