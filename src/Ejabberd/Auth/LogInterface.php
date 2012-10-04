<?php

/**
 * Ejabberd auth logger interface
 * 
 * PHP version 5.3
 * 
 * @category  Xamin
 * @package   Ejabberd
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2012 (c) ParsPooyesh Co
 * @license   GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version   GIT: $Id$
 * @link      http://xamin.ir
 */

/**
 * Auth logger interface
 * 
 * @category  Xamin
 * @package   Ejabberd
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2012 (c) ParsPooyesh Co
 * @license   GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version   Release: @package_version@
 * @link      http://xamin.ir
 */
interface Ejabberd_Auth_LogInterface
{
    /**
     * Debug log
     *
     * Detailed debug information.
     * 
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function debug($message);

    /**
     * Info log
     *
     * Interesting events. Examples: User logs in, SQL logs.
     * 
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function info($message);

    /**
     * Notice log
     * 
     * Normal but significant events.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function notice($message);

    /**
     * warning log
     *
     * Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function warning($message);

    /**
     * error log
     * 
     * Runtime errors that do not require immediate action but should typically be logged and monitored.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function error($message);

    /**
     * critical log
     * 
     * Critical conditions. Example: Application component unavailable, unexpected exception.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function critical($message);

}