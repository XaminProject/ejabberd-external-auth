<?php

/**
 * Ejabberd auth interface
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
 * Auth interface
 * 
 * @category  Xamin
 * @package   Ejabberd
 * @author    fzerorubigd <fzerorubigd@gmail.com>
 * @copyright 2012 (c) ParsPooyesh Co
 * @license   GPLv3 <http://www.gnu.org/licenses/gpl-3.0.html>
 * @version   Release: @package_version@
 * @link      http://xamin.ir
 */
interface Ejabberd_Auth_AuthInterface
{
    /**
     * isuser operation ejabberd
     *
     * @param string $user   username to check
     * @param string $server server name 
     *
     * @return boolean true if exist
     */
    public function isuserOper($user, $server);

    /**
     * auth operation 
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function authOper($user, $server, $password);

    /**
     * set password operation 
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function setpassOper($user, $server, $password);

    /**
     * register new user
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function tryregisterOper($user, $server, $password);

    /**
     * remove user
     *
     * @param string $user   user name to authenticate
     * @param string $server server name 
     *
     * @return boolean true on success
     */
    public function removeuserOper($user, $server);

    /**
     * safe remove user
     *
     * @param string $user     user name to authenticate
     * @param string $server   server name 
     * @param string $password password
     *
     * @return boolean true on success
     */
    public function removeuser3Oper($user, $server, $password);

}
