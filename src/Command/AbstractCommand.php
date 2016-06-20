<?php

namespace MetricsMonitor\Command;

use MetricsMonitor\Application;
use Symfony\Component\Console\Command\Command;

/**
 * @package MetricsMonitor\Command
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     * @param string      $name
     */
    public function __construct(Application $app, $name = null)
    {
        parent::__construct($name);

        $this->app = $app;
    }
}
