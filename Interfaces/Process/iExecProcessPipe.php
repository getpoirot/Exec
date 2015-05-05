<?php
namespace Poirot\Exec\Interfaces\Process;

use Poirot\Stream\Interfaces\iStreamable;
use Poirot\Exec\Interfaces\iExecDescriptor;

/**
 * It's implement descriptor interface except of values
 * values are initialized resource now, after exec
 *
 * - this made on ExecPro::exec method and injected
 *   to iExecProcess
 */
interface iExecProcessPipe extends iExecDescriptor
{
    /**
     * Is Pipes Resources Initialized Into Object?
     *
     * @return boolean
     */
    function isInitialized();

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
