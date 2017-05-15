<?php
/*
 * This file is fake createor and browser info of the app service.
 *
 * Faker is a PHP library that generates fake data for you. Whether you need to bootstrap your database, create good-looking XML documents,
 * fill-in your persistence to stress test it, or anonymize data taken from a production service, Faker is for you.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;

/**
 * Represents a faker class.
 *
 * main call
 * return type string
 */

class faker {

    //faker obj
    public $faker;

    public function __construct(){

        //get faker instance model
        $this->faker=\Faker\Factory::create();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public static function __callStatic($name,$arg=array())
    {
        $instance=new static;
        $method='get'.ucfirst($name).'';
        return $instance->$method($arg);
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getName($arg=array())
    {
        return $this->faker->name();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getLastName($arg=array())
    {
        return $this->faker->lastName();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getUsername($arg=array())
    {
        return $this->faker->userName();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getPassword($arg=array())
    {
        if(count($arg)){
            if(array_key_exists(1,$arg)){
                return $this->faker->password($arg[0],$arg[1]);
            }

            return $this->faker->password($arg[0]);

        }
        return $this->faker->password();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getPhoneNumber($arg=array())
    {
        return $this->faker->phoneNumber();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getText($arg=array())
    {
        if(count($arg)){
            return $this->faker->text($arg[0]);
        }
        return $this->faker->text();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getAddress($arg=array())
    {
        return $this->faker->address();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getCity($arg=array())
    {
        return $this->faker->city();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getCitySuffix($arg=array())
    {
        return $this->faker->citySuffix();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getPostcode($arg=array())
    {
        return $this->faker->postcode();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getCountry($arg=array())
    {
        return $this->faker->country();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getCountryCode($arg=array())
    {
        return $this->faker->countryCode();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getLatitude($arg=array())
    {
        return $this->faker->latitude();
    }


    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getLongitude($arg=array())
    {
        return $this->faker->longitude();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getUnixTime($arg=array())
    {
        return $this->faker->unixTime();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getDate($arg=array())
    {
        if(count($arg)){
            if(array_key_exists(1,$arg)){
                return $this->faker->date($arg[0],$arg[1]);
            }

            return $this->faker->date($arg[0]);

        }
        return $this->faker->date();
    }

    /**
     * faker call_static get data.
     *
     * @return faker class
     */
    public function getTime($arg=array())
    {
        if(count($arg)){
            if(array_key_exists(1,$arg)){
                return $this->faker->time($arg[0],$arg[1]);
            }

            return $this->faker->time($arg[0]);

        }
        return $this->faker->time();
    }



}
