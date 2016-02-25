<?php
namespace Poirot\Exec;

use Poirot\Std\Interfaces\Struct\iEntityData;
use Poirot\Std\SetterBuilderTrait;
use Poirot\Exec\Interfaces\ipExec;
use Poirot\Std\Struct\EntityData;
use Poirot\Std\Struct\OpenOptionsData;

class ExeProc implements ipExec
{
    use SetterBuilderTrait;

    /**
     * @var iEntityData
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
     * @var OpenOptionsData
     */
    protected $_options;

    /**
     * Construct
     *
     * @param array $setter
     */
    function __construct(array $setter = null)
    {
       if ($setter !== null)
           $this->setupFromArray($setter, true);
    }

    /**
     * Default Environment Variables
     *
     * - An Entity with the environment variables for the command
     *   that will be runAn array with the environment variables
     *   for the command that will be run
     *
     * @return EntityData
     */
    function env()
    {
        if (!$this->env)
            $this->env = new EntityData;

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
     * @return ExeDescriptor
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
     * @param string $cmd
     * @param null|string $cwd
     *
     * @throws \Exception
     * @return ExeProcuted
     */
    function exec($cmd, $cwd = null)
    {
        ($cwd !== null) ?: $cwd = $this->getCwd();

        $pipes   = [];
        $process = proc_open(
            $cmd
            , $this->descriptor()->toArray()
            , $pipes
            , $cwd
            , \Poirot\Std\iterator_to_array($this->env())
            , \Poirot\Std\iterator_to_array($this->optsData())
        );

        if (!is_resource($process))
            throw new \Exception('Error While Opening Process');

        // Build Pipe Initialized:
        // TODO can use as method inside iExecProcessPipe
        $procPipe = new ExeProcutedPipes($this->descriptor(), $pipes);

        return new ExeProcuted($process, $procPipe);
    }

    /**
     * @return OpenOptionsData
     */
    function optsData()
    {
        if (!$this->_options)
            $this->_options = self::newOptsData();

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
     * @param null|mixed $builder Builder Options as Constructor
     *
     * @return OpenOptionsData
     */
    static function newOptsData($builder = null)
    {
        return (new OpenOptionsData)->from($builder);
    }
}
