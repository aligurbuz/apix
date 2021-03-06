<?php
// bootstrap.php
require_once "./vendor/autoload.php";


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$paths = array("");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'=>'driver',
    'host'=>'host',
    'user'=>'user',
    'password'=>'password',
    'dbname'=>'dbname',
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);

// registering noop annotation autoloader - allow all annotations by default
AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);
$entityManager = EntityManager::create($dbParams, $config);

