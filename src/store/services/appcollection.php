<?php
/*
 * This file is usefull class and collection of the api service.
 *
 * client and collection info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;
use Illuminate\Support\Collection;

/**
 * Represents a collection class.
 *
 * main call
 * return type string
 */

class appCollection {


    /**
     * collection all get data.
     * The all method returns the underlying array represented by the collection:
     * @return collection class
     */
    public function all($data=array())
    {
        if(count($data)){
            return collect($data)->all();
        }
        return null;
    }

    /**
     * collection avg get data.
     * The avg method returns the average of all items in the collection:
     * If the collection contains nested arrays or objects,
     * you should pass a key to use for determining which values to calculate the average:
     * @return collection class
     */
    public function avg($data=array(),$key=null)
    {
        if(count($data)){
            if($key==null){
                return collect($data)->avg();
            }
            return collect($data)->avg($key);
        }
        return null;
    }

    /**
     * collection chunk get data.
     * The chunk method breaks the collection into multiple, smaller collections of a given size:
     * @return collection class
     */
    public function chunk($data=array(),$chunk)
    {
        if(count($data)){
            $collect=collect($data)->chunk($chunk);
            return $collect->toArray();
        }
        return null;
    }

    /**
     * collection collapse get data.
     * The collapse method collapses a collection of arrays into a single, flat collection:
     * @return collection class
     */
    public function collapse($data=array())
    {
        if(count($data)){
            $collect=collect($data)->collapse();
            return $collect->all();
        }
        return null;
    }

    /**
     * collection combine get data.
     * The combine method combines the keys of the collection with the values of another array or collection:
     * @return collection class
     */
    public function combine($data=array(),$combineArray=array())
    {
        if(count($data)){
            $collect=collect($data)->combine($combineArray);
            return $collect->all();
        }
        return null;
    }


    /**
     * collection contains get data.
     * The contains method determines whether the collection contains a given item:
     * You may also pass a key / value pair to the contains method, which will determine if the given pair exists in the collection:
     * Finally, you may also pass a callback to the contains method to perform your own truth test
     * @return collection class
     */
    public function contains($data=array(),$containvalue,$containkey=null)
    {
        if(count($data)){

            //collect data
            $collect=collect($data);

            if($containkey==null){

                //callback $containvalue
                if(is_callable($containvalue)){
                    return $collect->contains($containvalue);
                }
                //$containkey is null
                return $collect->contains($containvalue);
            }

            //$containkey is not null
            return $collect->contains($containkey,$containvalue);

        }
        return null;
    }

    /**
     * collection count get data.
     * The count method returns the total number of items in the collection:
     * @return collection class
     */
    public function count($data=array())
    {
        if(count($data)){
            return collect($data)->count();
        }
        return null;
    }

    /**
     * collection diff get data.
     * The diff method compares the collection against another collection or a plain PHP array based on its values.
     * This method will return the values in the original collection that are not present in the given collection:
     * @return collection class
     */
    public function diff($data=array(),$diffArray=array())
    {
        if(count($data)){
            $collect=collect($data)->diff($diffArray);
            return $collect->all();
        }
        return null;
    }

    /**
     * collection max get data.
     * The max method returns the maximum value of a given key:
     * @return collection class
     */
    public function max($data=array(),$key=null)
    {
        if(count($data)){
            if($key===null){
                return collect($data)->max();
            }
            return collect($data)->max($key);

        }
        return null;
    }

    /**
     * collection min get data.
     * The max method returns the minimum value of a given key:
     * @return collection class
     */
    public function min($data=array(),$key=null)
    {
        if(count($data)){
            if($key===null){
                return collect($data)->min();
            }
            return collect($data)->min($key);

        }
        return null;
    }

    /**
     * collection sum get data.
     * The sum method returns the sum of all items in the collection:
     * @return collection class
     */
    public function sum($data=array(),$callback=null)
    {
        if(count($data)){
            if(is_callable($callback)){
                return collect($data)->sum($callback);
            }

            if($callback===null){
                return collect($data)->sum();
            }
            return collect($data)->sum($callback);


        }
        return null;
    }

    /**
     * collection diffKeys get data.
     * The diffKeys method compares the collection against another collection or a plain PHP array based on its keys.
     * This method will return the key / value pairs in the original collection that are not present in the given collection.
     * @return collection class
     */
    public function diffKeys($data=array(),$diffKeysArray=array())
    {
        if(count($data)){
            $collect=collect($data)->diffKeys($diffKeysArray);
            return $collect->all();
        }
        return null;
    }

    /**
     * collection except get data.
     * The except method returns all items in the collection except for those with the specified keys
     * @return collection class
     */
    public function except($data=array(),$exceptArray=array())
    {
        if(count($data)){
            $collect=collect($data)->except($diffKeysArray);
            return $collect->all();
        }
        return null;
    }

    /**
     * collection filter get data.
     * The filter method filters the collection using the given callback, keeping only those items that pass a given truth test:
     * @return collection class
     */
    public function filter($data=array(),$callback=null)
    {
        if(count($data)){
            if(is_callable($callback)){
                $collect=collect($data)->filter($callback);
            }
            else{
                $collect=collect($data)->filter();
            }

            return $collect->all();
        }
        return null;
    }

    /**
     * collection first get data.
     * The first method returns the first element in the collection that passes a given truth test:
     * @return mixed
     */
    public function first($data=array(),$callback=null)
    {
        if(count($data)){
            if(is_callable($callback)){
                return collect($data)->first($callback);
            }
            else{
                return collect($data)->first();
            }

        }
        return null;
    }


    /**
     * @param $data array
     * @param $search
     * @param $loose
     * The search method searches the collection for the given value and returns its key if found.
     * If the item is not found, false is returned.
     * @return mixed
     */
    public function search($data=array(),$search,$loose=false)
    {
        if(count($data)){
            return collect($data)->search($search,$loose);
        }
        return null;
    }



}
