<?php

namespace MetricsMonitor\Exception;

/**
 * @package FooBar\Exception
 */
class ParserException extends AbstractException
{
    /**
     * @param string $message
     *
     * @return static
     */
    public static function create($message)
    {
        return parent::throwException($message);
    }
}
