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
class Ejabberd_Auth
{
    /**
     * @var Ejabberd_Auth_AuthInterface interface to intract with ejabberd
     */
    private $_authInterface;

    /**
     * @var Ejabberd_Auth_LogInterface log interface
     */
    private $_logInterface;

    /**
     * @var resource stdin for this script
     */ 
    private $_stdin;

    /**
     * @var resource stdout for this script
     */ 
    private $_stdout;

    /**
     * Constructor 
     *
     * @param Ejabberd_Auth_AuthInterface $authInterface authentication interface
     * @param Ejabberd_Auth_LogInterface  $logInterface  Log interface
     *
     * @return void
     */
    public function __construct(Ejabberd_Auth_AuthInterface $authInterface, Ejabberd_Auth_LogInterface $logInterface)
    {
        $this->_authInterface = $authInterface;
        $this->_logInterface = $logInterface;

        $this->_stdin  = fopen('php://stdin', 'rb');
        $this->_stdout = fopen('php://stdout', 'wb');
    }
    
    /**
     * Start to parse input and do the actions, main loop is here
     * 
     * @return void
     */
    public function serve()
    {
        //If you need to do more, you can overwrite this. 
        $this->_logInterface->info('Authenticator started.');
        $this->_doServe();
        $this->_logInterface->info('Authenticator stoped.');
    }
    
    /**
     * real magic happen here
     *
     * @return void 
     */
    final private function _doServe()
    {
        while (true) {
            try {
                $message = $this->_doRead();
                $command = $this->_doParse($message);
            } catch (UnexpectedValueException $e) {
                //Normally we can ignore this
                $this->_logInterface->error($e->getMessage());
                continue;
            } catch (RuntimeException $e) {
                //Critical error, stop.
                $this->_logInterface->critical($e->getMessage());
                return;
            }
            
            $responce = false;
            $this->_logInterface->notice(sprintf('Running %s command', $command['command']));
            switch ($command['command']) {
            case 'isuser' : 
                $responce = $this->_authInterface->isuserOper($command['user'], $command['server']);
                break;
            case 'auth' : 
                $responce = $this->_authInterface->authOper($command['user'], $command['server'], $command['password']);
                break;
            case 'setpass' : 
                $responce = $this->_authInterface->setpassOper($command['user'], $command['server'], $command['password']);
                break;
            case 'tryregister' : 
                $responce = $this->_authInterface->tryregisterOper($command['user'], $command['server'], $command['password']);
                break;
            case 'removeuser' : 
                $responce = $this->_authInterface->removeuserOper($command['user'], $command['server']);
                break;
            case 'removeuser3' : 
                $responce = $this->_authInterface->removeuser3Oper($command['user'], $command['server'], $command['password']);
                break;
            default :
                $this->_logInterface->warning(sprintf('Invalid command : %s', $command['command']));
                continue 2;
            }
            $this->_doRespond($responce);
        }
    }

    /**
     * Read next command from ejabberd
     *
     * @return string command line 
     * @throw RuntimeException fatal error
     * @throw UnexpectedValueException invalid value
     */
    final private function _doRead()
    {
        $length = fgets($this->_stdin, 3);
        if (feof($this->_stdin)) {
            throw new RuntimeException('Pipe broken');
        }

        $length = current(unpack('n', $length));
        if (!$length) {
            throw new UnexpectedValueException("Invalid length value, won't continue reading");
        }

        $message = fgets($this->_stdin, $length + 1);
        //TODO : {fzerorubigd} throw exception on invalid size?
        $this->_logInterface->debug(sprintf('Read "%s" must be %d and is %d ', $message, $length, strlen($message)));
        return $message;
    }

    /**
     * Parse message for ejabberd command
     *  
     * @param string $message message to parse
     * 
     * @return array 
     */
    final private function _doParse($message)
    {
        $messageArray = explode(':', $message, 4);
        if (count($message) < 3) {
            throw new UnexpectedValueException(sprintf('Message is too short: "%s"', $message));
        }
        
        list($command, $user, $server) = $messageArray;
        $password = isset($messageArray[3]) ? $messageArray[3] : null;
        $this->_logInterface->debug(sprintf('Extracted variables : command : %s, user : %s, server : %s , password : *****', $command, $user, $server));
        return compact('command', 'user', 'server', 'password');
    }

    /**
     * Respond to ejabberd 
     *
     * @param boolean $status last action is successfull or not?
     * 
     * @return void
     */
    final private function _doRespond($status)
    {
        $resp = $status ? 1 : 0;
        $message = pack('nn', 2, $resp);
        $this->_logInterface->debug('Sending response: ' . $resp);
        fwrite($this->_stdout, $message);
    }

}