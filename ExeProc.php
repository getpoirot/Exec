<?php
namespace Poirot\Exec;

use Poirot\Core\AbstractOptions;
use Poirot\Core\Entity;
use Poirot\Core\Interfaces\EntityInterface;
use Poirot\Core\OpenOptions;
use Poirot\Exec\Interfaces\iExec;
use Poirot\Exec\Interfaces\iExecDescriptor;
use Poirot\Exec\Interfaces\Process\iExecProcess;

class ExeProc implements iExec
{
    /**
     * @var EntityInterface
     */
    protected $env;

    /**
     * @var string
     */
    protected $_cwd;

    /**
     * @var ExeDescriptor
     */
    protected $_descriptor;

    /**
     * @var OpenOptions
     */
    protected $_options;

    /**
     * Default Environment Variables
     *
     * - An Entity with the environment variables for the command
     *   that will be runAn array with the environment variables
     *   for the command that will be run
     *
     * @return EntityInterface
     */
    function env()
    {
        if (!$this->env)
            $this->env = new Entity();

        return $this->env;
    }

    /**
     * The initial absolute working dir for the commands
     *
     * @param string $cwd
     *
     * @return $this
     */
    function setCwd($cwd)
    {
        $this->_cwd = $cwd;
    }

    /**
     * Path To CWD of execution commands.
     *
     * @return string
     */
    function getCwd()
    {
        if (!$this->_cwd)
            $this->setCwd(getcwd());

        return $this->_cwd;
    }

    /**
     * Pipe Descriptor
     *
     * @return iExecDescriptor
     */
    function descriptor()
    {
        if (!$this->_descriptor)
            $this->_descriptor = new ExeDescriptor();

        return $this->_descriptor;
    }

    /**
     * Execute a command
     *
     * @param string      $cmd
     * @param null|string $cwd
     *
     * @return iExecProcess
     */
    function exec($cmd, $cwd = null)
    {

    }

    /**
     * @return OpenOptions
     */
    function options()
    {
        if (!$this->_options)
            $this->_options = self::optionsIns();

        return $this->_options;
    }

    /**
     * Get An Bare Options Instance
     *
     * ! it used on easy access to options instance
     *   before constructing class
     *   [php]
     *      $opt = Filesystem::optionsIns();
     *      $opt->setSomeOption('value');
     *
     *      $class = new Filesystem($opt);
     *   [/php]
     *
     * @return AbstractOptions
     */
    static function optionsIns()
    {
        return new OpenOptions();
    }
}