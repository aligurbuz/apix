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
        return (self::$_instance==null) ? new self() : self::$_instance;

    }

    /**
     * Register the session.
     *
     * @param integer $time.
     */
    public static function register($time = 60)
    {
        self::$_instance=self::getInstance();

        $_SESSION['session_id'] = session_id();
        $_SESSION['session_time'] = intval($time);
        $_SESSION['session_start'] = $this->newTime();
    }
    /**
     * Checks to see if the session is registered.
     *
     * @return  True if it is, False if not.
     */
    public static function isRegistered()
    {
        self::$_instance=self::getInstance();

        if (! empty($_SESSION['session_id'])) {
            return true;
        } else {
            return false;
        }
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
     * Retrieve the global session variable.
     *
     * @return array
     */
    public static function getSession()
    {
        self::$_instance=self::getInstance();
        return $_SESSION;
    }
    /**
     * Gets the id for the current session.
     *
     * @return integer - session id
     */
    public static function getSessionId()
    {
        self::$_instance=self::getInstance();
        return $_SESSION['session_id'];
    }
    /**
     * Checks to see if the session is over based on the amount of time given.
     *
     * @return boolean
     */
    public static function isExpired()
    {
        self::$_instance=self::getInstance();
        if ($_SESSION['session_start'] < $this->timeNow()) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Renews the session when the given time is not up and there is activity on the site.
     */
    public static function renew()
    {
        self::$_instance=self::getInstance();
        $_SESSION['session_start'] = $this->newTime();
    }
    /**
     * Returns the current time.
     *
     * @return unix timestamp
     */
    private static function timeNow()
    {
        self::$_instance=self::getInstance();
        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, $currentMin, $currentSec, $currentMon, $currentDay, $currentYear);
    }
    /**
     * Generates new time.
     *
     * @return unix timestamp
     */
    private static function newTime()
    {
        self::$_instance=self::getInstance();

        $currentHour = date('H');
        $currentMin = date('i');
        $currentSec = date('s');
        $currentMon = date('m');
        $currentDay = date('d');
        $currentYear = date('y');
        return mktime($currentHour, ($currentMin + $_SESSION['session_time']), $currentSec, $currentMon, $currentDay, $currentYear);
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