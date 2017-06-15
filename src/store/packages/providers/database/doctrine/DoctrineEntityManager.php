<?php namespace src\store\packages\providers\database\doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class DoctrineEntityManager {

    public function getDoctrine($model=null){


        $getCalledClassArray=explode("\\",get_called_class());
        if($model===null){
            $model=str_replace('Builder','',end($getCalledClassArray));
        }



        $paths = array("");
        $isDevMode = false;

        // the connection configuration
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'user'     => 'root',
            'password' => '280384483082',
            'dbname'   => 'Prosystem',
        );

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);
        $entityManager = EntityManager::create($dbParams, $config);

        return $entityManager->getRepository('src\app\\'.app.'\\'.version.'\model\doctrine\\'.$model);
    }
}