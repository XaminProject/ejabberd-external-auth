<?php

/**
 * Ejabberd auth log class
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
 * Ejabbered auth class
 * 
 * @category  Xamin
 * @package   Ejabberd
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2012 (c) ParsPooyesh Co
 * @license   GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version   Release: @package_version@
 * @link      http://xamin.ir
 */
class MyLog implements Ejabberd_Auth_LogInterface
{
    /**
     * Logger
     */
    private $_file;
    
    /**
     * Create new logger
     * 
     * @param string $address file address
     *
     * @return void
     */
    public function __construct($address) 
    {
        if (!is_writable($address)) {
            throw new RuntimeException($address . ' is not writable');
        }
        $this->_file = fopen($address, 'a');
    }

    /**
     * Actual log function
     * 
     * @param string $message message to log
     *
     * @return void
     */
    private function _log($message)
    {
        $message = sprintf("[%8s] : %s %s", date('H:i:s'), $message, PHP_EOL);
        fwrite($this->_file, $message);
    }
    
    /**
     * Debug log
     *
     * Detailed debug information.
     * 
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function debug($message)
    {
        $this->_log(sprintf('[%8s] %s', 'DEBUG', $message));
    }

    /**
     * Info log
     *
     * Interesting events. Examples: User logs in, SQL logs.
     * 
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function info($message)
    {
        $this->_log(sprintf('[%8s] %s', 'INFO', $message));
    }

    /**
     * Notice log
     * 
     * Normal but significant events.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function notice($message)
    {
        $this->_log(sprintf('[%8s] %s', 'NOTICE', $message));
    }

    /**
     * warning log
     *
     * Exceptional occurrences that are not errors. Examples: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function warning($message)
    {
        $this->_log(sprintf('[%8s] %s', 'WARNING', $message));
    }

    /**
     * error log
     * 
     * Runtime errors that do not require immediate action but should typically be logged and monitored.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function error($message)
    {
        $this->_log(sprintf('[%8s] %s', 'ERROR', $message));
    }

    /**
     * critical log
     * 
     * Critical conditions. Example: Application component unavailable, unexpected exception.
     *
     * @param string $message message to log in this level
     *
     * @return void
     */
    public function critical($message)
    {
        $this->_log(sprintf('[%8s] %s', 'CRITICAL', $message));
    }

}