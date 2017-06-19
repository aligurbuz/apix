<?php
/*
 * Redis is not a plain key-value store, actually it is a data structures server, supporting different kind of values.
 * What this means is that, while in traditional key-value stores you associated string keys to string values,
 * in Redis the value is not limited to a simple string, but can also hold more complex data structures.
 */

namespace src\store\services;
use Predis\Client as client;

/**
 * Represents a redis class.
 *
 * main call
 * return type string
 */

class redis {

    public $client;

    /**
     * redis configuration.
     *
     * @return redis @connection
     */
    public function __construct(client $client){

        //redis client
        $this->client=$client;
    }


    /**
     * Returns PONG if no argument is provided, otherwise return a copy of the argument as a bulk.
     * This command is often used to test if a connection is still alive, or to measure latency.
     * If the client is subscribed to a channel or a pattern, it will instead return a multi-bulk with a "pong"
     * in the first position and an empty bulk in the second position, unless an argument is
     * provided in which case it returns a copy of the argument.
     *
     * @return redis @data
     */
    public function ping($message='hello redis'){

        //get ping return
        return $this->client->ping($message);

    }


    /**
     * Select the DB with having the specified zero-based numeric index.
     * New connections always use DB 0.
     *
     * @return redis @data
     */
    public function select($databaseNumber=0){

        //get ping return
        return $this->client->select($databaseNumber);

    }


    /**
     * Set key to hold the string value. If key already holds a value, it is overwritten,
     * regardless of its type. Any previous time to live associated with the key is
     * discarded on successful SET operation.
     *
     * @return redis @data
     */
    public function set($data,$expire=null){

        //set return
        if($this->client->set($data[0],$data[1])){
            if($expire!==null && is_numeric($expire)){
                $this->expire($data[0],$expire);
                return true;
            }
            return true;
        }

        return false;

    }

    /**
     * If key already exists and is a string, this command appends the value at the end of the string.
     * If key does not exist it is created and set as an empty string,
     * so APPEND will be similar to SET in this special case.
     *
     * @return redis @data
     */
    public function append($key=null,$value=null){

        //get append
        if($key!==null && $value!==null){
            return $this->client->append($key,$value);
        }
        return null;

    }


    /**
     * Get the value of key. If the key does not exist the special value nil is returned.
     * An error is returned if the value stored at key is not a string,
     * because GET only handles string values.
     *
     * @return redis @data
     */
    public function get($key=null){

        //get data
        if($key!==null){
            return $this->client->get($key);
        }

        return null;

    }

    /**
     * Returns if key exists.
     * Since Redis 3.0.3 it is possible to specify multiple keys instead of a single one.
     * In such a case, it returns the total number of keys existing.
     * Note that returning 1 or 0 for a single key is just a special case of the variadic usage,
     * so the command is completely backward compatible.
     * The user should be aware that if the same existing key is mentioned in the arguments multiple times,
     * it will be counted multiple times. So if somekey exists, EXISTS somekey somekey will return 2.
     *
     * @return redis @data
     */
    public function exists($key){

        //get exists
        if($this->client->exists($key)){
            return true;
        }
        return false;
    }


    /**
     * Set a timeout on key. After the timeout has expired,
     * the key will automatically be deleted. A key with an associated timeout is often said
     * to be volatile in Redis terminology.
     *
     * @return redis class
     */
    public function expire($key,$ttl){

        //get expire
        $this->client->expire($key,$ttl);
    }

    /**
     * Returns the remaining time to live of a key that has a timeout.
     * This introspection capability allows a Redis client to check
     * how many seconds a given key will continue to be part of the dataset.
     *
     * @return redis @data
     */
    public function ttl($key=null){

        //get remaining time
        if($key!==null){
            return $this->client->ttl($key);
        }
        return null;

    }

    /**
     * Delete all the keys of the currently selected DB. This command never fails.
     * The time-complexity for this operation is O(N), N being the number of keys in the database.
     *
     * @return redis class
     */
    public function flushdb(){

        //get flush db
        $this->client->flushdb();
    }

    /**
     * Available since 1.0.0.
     * Delete all the keys of all the existing databases, not just the currently selected one. This command never fails.
     * The time-complexity for this operation is O(N), N being the number of keys in all existing databases..
     *
     * @return redis @data
     */
    public function flushAll(){

        //get flush All
        $this->client->flushall();
    }

    /**
     * Removes the specified keys. A key is ignored if it does not exist.
     *
     * @return redis @data
     */
    public function delete($keys=array()){

        //get delete
        if(is_array($keys) && count($keys)){
            return $this->client->del($keys);
        }
    }

    /**
     * Returns all keys matching pattern.
     * While the time complexity for this operation is O(N), the constant times are fairly low.
     * For example, Redis running on an entry level laptop can scan a 1 million key database in 40 milliseconds.
     * Warning: consider KEYS as a command that should only be used in production environments with extreme care.
     * It may ruin performance when it is executed against large databases.
     * This command is intended for debugging and special operations, such as changing your keyspace layout.
     * Don't use KEYS in your regular application code.
     * If you're looking for a way to find keys in a subset of your keyspace, consider using SCAN or sets.
     *
     * @return redis @data
     */
    public function getAllKeys($pattern="*"){

        //get keys
        return $this->client->keys($pattern);
    }

    /**
     * Serialize the value stored at key in a Redis-specific format and return it to the user.
     * The returned value can be synthesized back into a Redis key using the RESTORE command.
     *
     * @return redis @data
     */
    public function dump($key=null){

        //get dump
        if($key!==null){
            return $this->client->dump($key);
        }
        return null;

    }

    /**
     * Return a random key from the currently selected database
     *
     * @return redis @data
     */
    public function getRandomKey(){

        //get keys
        return $this->client->randomkey();
    }

    /**
     * Sets field in the hash stored at key to value. If key does not exist,
     * a new key holding a hash is created. If field already exists in the hash, it is overwritten.
     *
     * @return redis @data
     */
    public function hset($key=null,$field=null,$value=null){

        //get h set
        if($key!==null && $field!==null && $value!==null){
            return $this->client->hset($key,$field,$value);
        }
        return null;

    }

    /**
     * Returns the value associated with field in the hash stored at key.
     *
     * @return redis @data
     */
    public function hget($key=null,$field=null){

        //get h get
        if($key!==null && $field!==null){
            return $this->client->hget($key,$field);
        }
        return null;

    }

    /**
     * Returns all fields and values of the hash stored at key. In the returned value,
     * every field name is followed by its value, so the length of the reply is twice the size of the hash.
     *
     * @return redis @data
     */
    public function hgetall($key=null){

        //get h get all
        if($key!==null){
            return $this->client->hgetall($key);
        }
        return null;

    }

    /**
     * Returns all field names in the hash stored at key.
     *
     * @return redis @data
     */
    public function hkeys($key=null){

        //get h keys
        if($key!==null){
            return $this->client->hkeys($key);
        }
        return null;

    }

    /**
     * Returns if field is an existing field in the hash stored at key.
     *
     * @return redis @data
     */
    public function hexists($key=null,$field=null){

        //get h keys
        if($key!==null && $field!==null){
            if($this->client->hexists($key,$field)===0){
                return false;
            }
            return true;
        }
        return null;

    }


    /**
     * Removes the specified fields from the hash stored at key. Specified fields that do not exist within this hash are ignored.
     * If key does not exist, it is treated as an empty hash and this command returns 0.
     *
     * @return redis @data
     */
    public function hdel($key=null,$field=null){

        //get h keys
        if($key!==null && $field!==null){
            if($this->client->hdel($key,$field)===0){
                return false;
            }
            return true;
        }
        return null;

    }




}
