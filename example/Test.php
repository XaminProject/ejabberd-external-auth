<?php

/**
 * Ejabberd test
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

require_once "vendor/autoload.php";
require_once "Auth.php";
require_once "Log.php";

$users = array (
    'testserver' => array (
        'fzerorubigd' => '123456',  //User name is pretty harder than password :D
        'test'       => 'dude'
        )
    
);

$authz = new MyAuth($users);
$log = new MyLog(__DIR__ . '/test.log');

$authenticator = new Ejabberd_Auth($authz, $log);

$authenticator->serve();