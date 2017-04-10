<?php
/*
 * This file is client and browser info of the fussy service.
 *
 * client and browser info
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace src\store\services;
use Carbon\Carbon;

/**
 * Represents a redis class.
 *
 * main call
 * return type string
 */

class date {


    /**
     * carbon diff get data.
     *
     * @return carbon class
     */
    public function diff($int)
    {
        Carbon::setLocale('en');
        //date_default_timezone_set('Europe/London');
        return Carbon::createFromTimestamp($int)->timezone(date_default_timezone_get())->diffForHumans();
    }

    /**
     * carbon date get data.
     *
     * @return carbon class
     */
    public function date($int)
    {
        Carbon::setLocale('en');
        //date_default_timezone_set('Europe/London');
        return Carbon::createFromTimestamp($int)->timezone(date_default_timezone_get());
    }

}
