<?php
namespace src\services;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

class httpSession
{
    public $session=null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $storage = new NativeSessionStorage(array(), new NativeFileSessionHandler(root.'/src/app/'.app.'/storage/session'));
        $this->session = new Session($storage);
    }

    /**
     * {@set} .
     */
    public function set($key=null,$value=null)
    {
        if($key!==null && $value!==null){
            return $this->session->set($key,$value);
        }
        return false;
    }


    /**
     * {@get} .
     */
    public function get($key=null)
    {
        if($key!==null){
            return $this->session->get($key);
        }
        return null;
    }

    /**
     * {@has}
     */
    public function has($name=null)
    {
        if($name!==null){
            return $this->session->has($name);
        }
        return false;
    }

    /**
     * {@all}
     */
    public function all()
    {
        return $this->session->all();
    }

    /**
     * {@remove}
     */
    public function remove($name=null)
    {
        if($name!==null){
            return $this->session->remove($name);
        }
        return null;
    }


    /**
     * {@clear}
     */
    public function clear()
    {
        return $this->session->clear();
    }



}