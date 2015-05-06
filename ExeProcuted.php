<?php
namespace Poirot\Exec;

use Poirot\Exec\Interfaces\Process\iExecProcess;
use Poirot\Exec\Interfaces\Process\iExecProcessPipe;

class ExeProcuted implements iExecProcess
{
    /**
     * @var resource Proc Open Resource
     */
    protected $_rHandler;

    /**
     * @var ExeProcutedPipes
     */
    protected $pipes;

    /**
     * Construct
     *
     * @param resource         $rHandler
     * @param iExecProcessPipe $pipes
     */
    function __construct($rHandler, iExecProcessPipe $pipes)
    {
        $this->setRhandler($rHandler);

        $this->pipes = $pipes;
    }

    /**
     * Set Proc Open Resource Handler
     *
     * @param resource $resource $resource
     *
     * @return $this
     */
    function setRhandler($resource)
    {
        $this->_rHandler = $resource;

        return $this;
    }

    /**
     * Get Proc Open Resource Handler
     *
     * @return resource
     */
    function getRhandler()
    {
        return $this->_rHandler;
    }

    /**
     * Get Process Pipes
     * include stdin, stdout, stderr
     *
     * @return ExeProcutedPipes
     */
    function pipes()
    {
        return $this->pipes;
    }

    /**
     * Close Process Open
     *
     * (!) It is important that you close any pipes before calling
     *     proc_close in order to avoid a deadlock
     *
     * @return void
     */
    function close()
    {
        foreach($this->pipes()->getDescriptors() as $dscNum) {
            // close all streams
        }

        proc_close($this->getRhandler());
    }
}
