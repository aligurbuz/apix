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


}
