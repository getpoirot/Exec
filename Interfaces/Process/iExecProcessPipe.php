<?php
namespace Poirot\Exec\Interfaces\Process;

use Poirot\Stream\Interfaces\iStreamable;

interface iExecProcessPipe
{
    /*
     The file descriptor numbers are not limited to 0, 1 and 2
     you may specify any valid file descriptor number and it will
     be passed to the child process. This allows your script to
     interoperate with other scripts that run as "co-processes".
     */
    const XCDSC_STDIN  = 0;
    const XCDSC_STDOUT = 1;
    const XCDSC_STDERR = 2;

    /**
     * Is Pipes Resources Initialized Into Object?
     *
     * @return boolean
     */
    function isInitialized();

    /**
     * Set Descriptor Resource
     *
     * @param int      $number
     * @param resource $value
     *
     * @return $this
     */
    function setDescriptor($number, $value);

    /**
     * Pipe To Specific Descriptor Number Resource
     *
     * - check initialized
     * - use resources that set from setDescriptor
     *
     * @param int $dscNum Descriptor Number
     *
     * @return iStreamable
     */
    function to($dscNum);
}
