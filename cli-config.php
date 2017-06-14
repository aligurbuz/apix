<?php
/**
 * Doctrine Cli-Config.
 *
 * Now that we have defined the Metadata mappings and bootstrapped the EntityManager
 * we want to generate the relational database schema from it. Doctrine has a Command-Line Interface
 * that allows you to access the SchemaTool, a component that generates the required tables to work with the metadata.
 * For the command-line tool to work a cli-config.php file has to be present in the project root directory,
 * where you will execute the doctrine command. Its a fairly simple file:
 * main loader as construct method
 */
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once './src/store/packages/providers/database/doctrine/bootstrap.php';
return ConsoleRunner::createHelperSet($entityManager);