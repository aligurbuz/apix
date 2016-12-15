<?php
namespace src\services;

class Session
{
    public static $_instance=null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        session_start();
    }
    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this);
    }

    /**
     * construct get instance for generate csrf token
     *
     * @param string request - defaults to the default symfony package
     * @return void
     */
    public static function getInstance()
    {
        //symfony request load
        $instance=(self::$_instance==null) ? new self() : self::$_instance;
        return $instance;

    }

    /**
     * Set key/value in session.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        self::$_instance=self::getInstance();

        $_SESSION[$key] = $value;
    }
    /**
     * Retrieve value stored in session by key.
     *
     * @var mixed
     */
    public static function get($key)
    {
        self::$_instance=self::getInstance();
        return isset($_SESSION[$key]) ? $_SESSION[$key]:false;
    }

    /**
     * Destroys the session.
     */
    public static function end()
    {
        self::$_instance=self::getInstance();
        session_destroy();
        $_SESSION = array();
    }
}