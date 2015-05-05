<?php
namespace Poirot\Exec;

use Poirot\Exec\Interfaces\iExecDescriptor;
use Poirot\Stream\Interfaces\iSResource;

class ExeDescriptor implements iExecDescriptor
{
    protected $_descriptors = [];

    /**
     * Construct
     *
     * - set default descriptors
     *
     */
    function __construct()
    {
        $this->setDescriptor(self::XCDSC_STDIN,  ['pipe', 'r']);
        $this->setDescriptor(self::XCDSC_STDOUT, ['pipe', 'w']);
        $this->setDescriptor(self::XCDSC_STDERR, ['pipe', 'w']);
    }

    /**
     * Set Descriptor For
     *
     * @param int $number
     * @param array|resource $value
     *
     * @return $this
     */
    function setDescriptor($number, $value)
    {
        $this->_validateValue($value);

        $this->_descriptors[$number] = $value;

        return $this;
    }

        protected function _validateValue($value)
        {
            if (is_object($value)) {
                if (!$value instanceof iSResource)
                    throw new \InvalidArgumentException(sprintf(
                        'Descriptor Object Value Must Instance Of iSResource but "%s" given.'
                        , get_class($value)
                    ));

                $value = $value->getRHandler();
            }

            // TODO Check for valid array

            if (!is_array($value) || !is_resource($value))
                throw new \InvalidArgumentException(sprintf(
                    'Descriptor Value Can Be iSResource Instance Or Array Or resource but "%s" given.'
                    , gettype($value)
                ));
        }

    /**
     * Get Descriptor Values,
     * - false if not have descriptor
     *
     * @param int $number Descriptor Number
     *                    - XCDSC_STDIN XCDSC_STDOUT XCDSC_STDERR
     *
     * @return false|array|resource
     */
    function getDescriptor($number)
    {
        return (in_array($number, $this->getDescriptors()))
            ? $this->_descriptors[$number]
            : false;
    }

    /**
     * Get Currently Presented Descriptors
     *
     * @return array[descriptor_name]
     */
    function getDescriptors()
    {
        return array_keys($this->_descriptors);
    }

    /**
     * To Array
     *
     * @return array
     */
    function toArray()
    {
       return $this->_descriptors;
    }
}
