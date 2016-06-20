<?php

namespace MetricsMonitor\Exception;

/**
 * @package FooBar\Exception
 */
abstract class AbstractException extends \Exception
{
    /**
     * @param string $message
     *
     * @return string
     */
    protected static function throwException($message)
    {
        return new static($message . PHP_EOL . '---' . PHP_EOL .
        'If you think that is an error or you missed a feature please refer to ' . PHP_EOL .
        'https://github.com/tommy-muehle/php-metrics-monitor/issues ' . PHP_EOL .
        'and create an issue. Thank you.');
    }
}
