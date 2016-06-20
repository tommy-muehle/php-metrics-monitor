<?php

namespace MetricsMonitor\Console;

use MetricsMonitor\Application as BaseApplication;
use MetricsMonitor\Service\Broker;
use MetricsMonitor\Service\Parser;
use MetricsMonitor\Service\Parser\CoverageParser;
use Symfony\Component\Console\Application as ConsoleApplication;
use MetricsMonitor\Command\AddCommand;
use MetricsMonitor\Command\RunCommand;

/**
 * Class Application
 *
 * @package MetricsMonitor\Console
 */
class Application extends BaseApplication
{
    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $app = $this;

        $this['broker'] = $this->share(function () use ($app) {
            $parser = new Parser;
            $parser->add(new CoverageParser());

            return new Broker($parser, $app['storage']);
        });

        $this['console'] = $this->share(function() use ($app) {
            $console = new ConsoleApplication('memo', $app['version']);
            $console->add(new RunCommand($app));
            $console->add(new AddCommand($app));

            return $console;
        });
    }
}
