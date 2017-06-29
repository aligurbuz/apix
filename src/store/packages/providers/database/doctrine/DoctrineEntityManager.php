<?php namespace src\store\packages\providers\database\doctrine;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class DoctrineEntityManager extends Config {


    public function getDoctrine($model=null){


        $getCalledClassArray=explode("\\",get_called_class());
        if($model===null){
            $model=str_replace('Builder','',end($getCalledClassArray));
        }

        $config = Setup::createAnnotationMetadataConfiguration($this->paths, $this->isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $this->paths);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);
        $entityManager = EntityManager::create($this->dbParams(), $config);

        if(defined('devPackage')){
            return $entityManager->getRepository('src\\store\\packages\\dev\\'.service.'\\devpack\\model\\doctrine\\'.$model);
        }

        return $entityManager->getRepository('src\app\\'.app.'\\'.version.'\model\doctrine\\'.$model);

    }
}