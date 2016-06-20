<?php

namespace MetricsMonitor\Exception;

use MetricsMonitor\Exception\AbstractException;

/**
 * @package MetricsMonitor\Exception
 */
class UnsupportedException extends AbstractException
{
    /**
     * @param \SplFileInfo $file
     *
     * @return static
     */
    public static function create(\SplFileInfo $file)
    {
        $message = sprintf('The given file "%s" seems not supported!', $file->getBasename());

        return parent::throwException($message);
    }
}
