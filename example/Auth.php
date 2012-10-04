<?php

/**
 * Ejabberd auth class
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
 * Ejabbered auth class sample. authz from an array
 * 
 * @category  Xamin
 * @package   Ejabberd
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2012 (c) ParsPooyesh Co
 * @license   GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version   Release: @package_version@
 * @link      http://xamin.ir
 */
class MyAuth implements Ejabberd_Auth_AuthInterface
{

    /**
     * @var array static users array 
     */
    private $_users;

    /**
     * Construct object
     * 
     * @param array $users users array, each key for server 
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->_users = $users;
    }
    /**
     * isuser operation ejabberd
     *
     * @param string $user   username to check
     * @param string $server server name 
     *
     * @return boolean true if exist
     */
    public function isuserOper($user, $server)
    {
        if (isset($this->_users[$server]) && isset($this->_users[$server][$user])) {
            return true;
        } 
        return false;
    }

    /**
     * auth operation 
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function authOper($user, $server, $password)
    {
        if ($this->isuserOper($user, $server) && $this->_users[$server][$user] == $password) {
            return true;
        }
        return false;
    }

    /**
     * set password operation 
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function setpassOper($user, $server, $password)
    {
        if ($this->isuserOper($user, $server)) {
            $this->_users[$server][$user] = $password;
            return true;
        }
        return false;
    }

    /**
     * register new user
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function tryregisterOper($user, $server, $password)
    {
        if ($this->isuserOper($user, $server)) {
            return false;
        }
        if (!is_array($this->_users[$server])) {
            $this->_users[$server] = array();
        }
        $this->_users[$server][$user] = $password;
        return true;
    }

    /**
     * remove user
     *
     * @param string $user   user name to authenticate
     * @param string $server server name 
     *
     * @return boolean true on success
     */
    public function removeuserOper($user, $server)
    {
        if (!$this->isuserOper($user, $server)) {
            return false;
        }
        unset($this->_users[$server][$user]);
        return true;
    }

    /**
     * safe remove user
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function removeuser3Oper($user, $server, $password)
    {
        if (!$this->authOper($user, $server, $password)) {
            return false;
        }
        unset($this->_users[$server][$user]);
        return true;
        
    }

}