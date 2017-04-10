<?php
/*
 * The Filesystem component provides basic utilities for the filesystem
 * The Filesystem class is the unique endpoint for filesystem operations:
 */

namespace src\store\services;
use Symfony\Component\Filesystem\Filesystem as Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * require the vendor/autoload.php file to enable the autoloading mechanism provided by Composer.
 * Otherwise, your application won't be able to find the classes of this Symfony component.
 * Methods mkdir(), exists(), touch(), remove(), chmod(), chown() and chgrp() can receive a string,
 * an array or any object implementing Traversable as the target argument.
 */
class fileProcess {

    private $fs;

    public function __construct(){
        $this->fs = new Filesystem();
    }

    /**
     * filesystem mkdir method.
     * mkdir() creates a directory.
     * On POSIX filesystems, directories are created with a default mode value 0777.
     * You can use the second argument to set your own mode
     *
     * @return filesystem class
     */
    public function mkdir($path=null,$dir=null,$chmod=0777)
    {
        if($path!==null && $dir!==null){
            try {
                $this->fs->mkdir($path.'/'.$dir,$chmod);
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }
        }
        return false;
    }


    /**
     * filesystem exists method.
     * exists() checks for the presence of all files or directories and returns false if a file is missing:
     * You can pass an array or any Traversable object as the first argument.
     * @return filesystem class
     */
    public function exists($path=null)
    {
        if($path!==null){
            return $this->fs->exists($path);
        }
        return false;
    }


    /**
     * copy() is used to copy files. If the target already exists, the file is copied only if the
     * source modification date is later than the target.
     * This behavior can be overridden by the third boolean argument:
     * @return filesystem class
     */
    public function copy($copied=null,$copying=null)
    {
        if($copied!==null && $copying!==null){
            return $this->fs->copy($copied,$copying,true);
        }
    }


    /**
     * touch() sets access and modification time for a file. The current time is used by default.
     * You can set your own with the second argument. The third argument is the access time:
     * @return filesystem class
     */
    public function touch($touch=null,$own=null,$access=null)
    {
        if($touch!==null){
            $this->fs->touch($touch,$own,$access);
        }
    }


}
