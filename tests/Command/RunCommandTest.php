<?php

namespace MetricsMonitor\Tests\Command;

use MetricsMonitor\Command\RunCommand;
use MetricsMonitor\Console\Application;

/**
 * @package MetricsMonitor\Tests\Command
 */
class RunCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandOptionsAndArgumentsAreExist()
    {
        $command = new RunCommand(new Application);

        $this->assertTrue($command->getDefinition()->hasArgument('address'));
        $this->assertTrue($command->getDefinition()->hasOption('docroot'));
        $this->assertTrue($command->getDefinition()->hasOption('router'));
    }

    public function testCommandMetaInformationsAreExist()
    {
        $command = new RunCommand(new Application);

        $this->assertEquals('run', $command->getName());
        $this->assertEquals('Provides the GUI for metrics monitor.', $command->getDescription());
        $this->assertNotEmpty($command->getHelp());
    }
}
