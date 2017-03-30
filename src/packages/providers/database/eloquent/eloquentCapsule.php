<?php namespace src\packages\providers\database\eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;

class eloquentCapsule {

    public $capsule;

    /**
     *
     */
    public function __construct(){

        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'Prosystem',
            'username'  => 'root',
            'password'  => 'laraappdevman*09',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Make this Capsule instance available globally via static methods... (optional)
        $this->capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->capsule->bootEloquent();
    }
}