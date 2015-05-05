<?php
namespace Poirot\Exec\Interfaces\Process;

interface iExecProcess
{
    /**
     * Get Process Pipes
     * include stdin, stdout, stderr
     *
     * @return iExecProcessPipe
     */
    function pipes();

    /**
     * Close Process Open
     *
     * (!) It is important that you close any pipes before calling
     *     proc_close in order to avoid a deadlock
     *
     * @return void
     */
    function close();
}
