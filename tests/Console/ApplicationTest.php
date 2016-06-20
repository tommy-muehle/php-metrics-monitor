<?php

namespace MetricsMonitor\Tests\Console;

use MetricsMonitor\Console\Application;
use MetricsMonitor\Service\Broker;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;

/**
 * @package MetricsMonitor\Tests\Console
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiredServicesAreExist()
    {
        $app = new Application;

        $this->assertInstanceOf(Broker::class, $app['broker']);
        $this->assertInstanceOf(ConsoleApplication::class, $app['console']);
        $this->assertInstanceOf(Command::class, $app['console']->get('run'));
        $this->assertInstanceOf(Command::class, $app['console']->get('add'));
    }
}
