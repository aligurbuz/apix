<?php
/*
 * This file make data cache for every service
 *
 * cache | symfony cache
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;
use Symfony\Component\Cache\Adapter\PhpFilesAdapter;
use Symfony\Component\Cache\Adapter\ProxyAdapter;
use src\store\services\fileProcess as file;

/**
 * Represents a cache class.
 *
 * main call
 * return type string
 */

class cache {

    private $adapter;
    private $cacheExpire;
    private $cache=null;
    private $name=null;
    private $directoryPath;


    /**
     * Constructor.
     *
     * @param type dependency injection and stk class
     * main loader as construct method
     */
    public function __construct(){

        $base=\Apix\staticPathModel::getAppServiceBase();
        $this->adapter=$base->cacheAdapter;


    }
    /**
     * cache adapter data.
     *
     * @return cache adapter method
     */
    public function adapter($adapter=null)
    {
        //adapter set
        if($adapter!==null){
            $this->adapter=$adapter;
        }
        return $this;
    }



    /**
     * cache expire data.
     *
     * @return cache expire method
     */
    public function expire($expire=null)
    {
        //expire set
        if($expire!==null){
            $this->cacheExpire=$expire;
        }
        return $this;
    }


    /**
     * cache name data.
     *
     * @return cache name method
     */
    public function name($name=null)
    {
        //name set
        if($name!==null){
            $this->name=$name;
        }
        return $this;
    }


    /**
     * cache name data.
     *
     * @return cache name method
     */
    public function getName()
    {
        //get Item
        if($this->name===null){
            $name="".request."_".service."_".method;
        }
        else{
            $name=$this->name;
        }

        return 'cache'.$name;
    }

    public function cachePath(){
        if($this->adapter==="file"){
            if(defined("devPackage")){
                $this->directoryPath ='./src/packages/dev/'.service.'/cache';
            }
            else{
                $this->directoryPath  = application.'/'.version.'/__call/'.service.'/cache';
                $file=new file();
                if(!$file->exists($this->directoryPath)){
                    $file->mkdir(application.'/'.version.'/__call/'.service.'','cache');
                }
            }
        }
    }


    /**
     * cache get data.
     *
     * @return cache class
     */
    public function get($callback)
    {
        $this->cachePath();

        //adapter set
        $adapterMethod=$this->adapter.'CacheAdapter';

        if($this->adapter==='file'){
            $this->$adapterMethod();
        }
        else{
            return $this->$adapterMethod($callback);
        }


        $name=$this->getName();

        $nameSet=$this->cache->getItem($name);

        //check is hit
        if (!$nameSet->isHit()) {
            // ... item does not exists in the cache
            $data=call_user_func($callback);
            $nameSet->set($data);
            $this->cache->save($nameSet);
            return $data;
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
            $defaultLifetime = $this->cacheExpire,
            // the main cache directory (the application needs read-write permissions on it)
            // if none is specified, a directory is created inside the system temporary directory
            $directory=$this->directoryPath

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
            $directory=$this->directoryPath
        );
    }


    /**
     * redis cache adapter.
     *
     * @return redis adapter class
     */
    public function redisCacheAdapter($callback)
    {
        $redisConnection=app('redis');
        $name=$this->getName();
        if(!$redisConnection->exists($name)){
            $data=call_user_func($callback);
            $redisConnection->set([$name,json_encode($data)]);
            if($this->cacheExpire!==null){
                $redisConnection->expire($name,$this->cacheExpire);
            }
        }
        return json_decode($redisConnection->get($name),1);
    }



}
