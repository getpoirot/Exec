<?php
namespace Poirot\Exec;

use Poirot\Exec\Interfaces\iExecDescriptor;
use Poirot\Exec\Interfaces\Process\iExecProcessPipe;
use Poirot\Stream\Interfaces\iStreamable;
use Poirot\Stream\SResource;
use Poirot\Stream\Streamable;

class ExeProcutedPipes extends ExeDescriptor
    implements iExecProcessPipe
{
    /**
     * @var boolean
     */
    protected $_isInitialized = false;

    /**
     * @see to()
     * @var array
     */
    protected $__cached_descriptors_stream = [];

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
     * stdin Proxy
     *
     * @throws \Exception
     * @return iStreamable
     */
    function stdin()
    {
        return $this->to(self::XCDSC_STDIN);
    }

    /**
     * stdout Proxy
     *
     * @throws \Exception
     * @return iStreamable
     */
    function stdout()
    {
        return $this->to(self::XCDSC_STDOUT);
    }

    /**
     * stderr Proxy
     *
     * @throws \Exception
     * @return iStreamable
     */
    function stderr()
    {
        return $this->to(self::XCDSC_STDERR);
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
        if (!$this->isInitialized())
            throw new \Exception("Pipes Not Initialized.");

        if (isset($this->__cached_descriptors_stream[$dscNum]))
            return $this->__cached_descriptors_stream[$dscNum];

        if (! in_array($dscNum, $this->getDescriptors()))
            throw new \Exception(sprintf(
                'Descriptor With Number "%s" not found.'
                , $dscNum
            ));

        $stream = new Streamable(new SResource($this->getDescriptor($dscNum)));
        $this->__cached_descriptors_stream[$dscNum] = $stream;

        return $stream;
    }

    // New Implementation Of Parent:
    // Used On self::setDescriptor() method
    protected function _validateValue($value)
    {
        if (!is_resource($value))
            throw new \InvalidArgumentException(sprintf(
                'Initialized Pipe Value Must Be resource but "%s" given.'
                , gettype($value)
            ));
    }
}
