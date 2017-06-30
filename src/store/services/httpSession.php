<?php
/*
 * The Symfony HttpFoundation component has a very powerful and
 * flexible session subsystem which is designed to provide session management
 * through a simple object-oriented interface using a variety of session storage drivers.
 */
namespace src\store\services;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;

class httpSession
{
    public $session=null;
    public static $instance=null;

    /**
     * Constructor.
     * Make sure your PHP session isn't already started before using the Session class.
     * If you have a legacy session system that starts your session
     * Symfony sessions are designed to replace several native PHP functions.
     * Applications should avoid using session_start(), session_regenerate_id(), session_id(),
     * session_name(), and session_destroy() and instead use the APIs in the following section.
     */
    public function __construct()
    {
        $storage = new NativeSessionStorage(array(), new NativeFileSessionHandler(application.'/storage/session'));
        $this->session = new Session($storage);

    }

    /**
     * {@set} .
     * Sets an attribute by key.
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
     * Gets an attribute by key.
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
     * Returns true if the attribute exists.
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
     * Gets all attributes as an array of key => value.
     */
    public function all()
    {
        return $this->session->all();
    }

    /**
     * {@remove}
     * Deletes an attribute by key.
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
     * Clear all attributes.
     */
    public function clear()
    {
        return $this->session->clear();
    }



}