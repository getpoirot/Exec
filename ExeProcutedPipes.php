<?php
namespace Poirot\Exec;

use Poirot\Exec\Interfaces\iExecDescriptor;
use Poirot\Exec\Interfaces\Process\iExecProcessPipe;
use Poirot\Stream\Interfaces\iStreamable;
use Poirot\Stream\Streamable;

class ExeProcutedPipes extends ExeDescriptor
    implements iExecProcessPipe
{
    /**
     * @var boolean
     */
    protected $_isInitialized = false;

    /**
     * Construct
     *
     * @param iExecDescriptor $desc
     * @param array           $proc_pipe
     *
     */
    function __construct(iExecDescriptor $desc, array $proc_pipe)
    {
        foreach($desc->getDescriptors() as $d) {
            $this->setDescriptor(
                $d
                , $proc_pipe[$d]
            );
        }

        $this->_isInitialized = true;
    }

    /**
     * Is Pipes Resources Initialized Into Object?
     *
     * @return boolean
     */
    function isInitialized()
    {
        return $this->_isInitialized;
    }

    /**
     * Pipe To Specific Descriptor Number Resource
     *
     * - check initialized
     * - use resources that set from setDescriptor
     *
     * @param int $dscNum Descriptor Number
     *
     * @throws \Exception
     * @return iStreamable
     */
    function to($dscNum)
    {
        if (! in_array($dscNum, $this->getDescriptors()))
            throw new \Exception(sprintf(
                'Descriptor With Number "%s" not found.'
                , $dscNum
            ));

        return new Streamable($this->getDescriptor($dscNum));
    }

    // New Implementation Of Parent:

    protected function _validateValue($value)
    {
        if (!is_resource($value))
            throw new \InvalidArgumentException(sprintf(
                'Initialized Pipe Value Must Be resource but "%s" given.'
                , gettype($value)
            ));
    }
}
