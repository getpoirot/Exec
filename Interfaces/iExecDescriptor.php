<?php
namespace Poirot\Exec\Interfaces;

interface iExecDescriptor
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

    /* Descriptor Options
     0 => array("pipe", "r"),                         // stdin is a pipe that the child will read from
     1 => array("pipe", "w"),                         // stdout is a pipe that the child will write to
     2 => array("file", "/tmp/error-output.txt", "a") // stderr is a file to write to
     */

    const XCDSC_PIP_FILE = 'file';
    const XCDSC_PIP_PIPE = 'pipe';

    /**
     * Set Descriptor For
     *
     * @param int            $number
     * @param array|resource $value
     *
     * @return $this
     */
    function setDescriptor($number, $value);

    /**
     * Get Descriptor Values,
     * - false if not have descriptor
     *
     * @param int $number Descriptor Number
     *                    - XCDSC_STDIN XCDSC_STDOUT XCDSC_STDERR
     *
     * @return false|array|resource
     */
    function getDescriptor($number);

    /**
     * Get Currently Presented Descriptors
     *
     * @return array[descriptor_name]
     */
    function getDescriptors();
}
