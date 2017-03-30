<?php namespace src\packages\providers\database\eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;

class eloquentCapsule {

    public $capsule;

    /**
     *
     */
    public function __construct(){

        $this->capsule = new Capsule;
        $config="\\src\\app\\".$app."\\".$version."\\config\\database";
        $configdb=$config::dbsettings();

        $this->capsule->addConnection([
            'driver'    => $configdb['driver'],
            'host'      => $configdb['host'],
            'database'  => $configdb['database'],
            'username'  => $configdb['user'],
            'password'  => $configdb['password'],
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