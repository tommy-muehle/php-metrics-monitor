<?php

namespace MetricsMonitor\Tests\Command;

use MetricsMonitor\Command\AddCommand;
use MetricsMonitor\Console\Application;
use MetricsMonitor\Exception\UnsupportedException;
use MetricsMonitor\Service\Broker;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * @package MetricsMonitor\Tests\Command
 */
class AddCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandOptionsAndArgumentsAreExist()
    {
        $command = new AddCommand(new Application);

        $this->assertTrue($command->getDefinition()->hasArgument('file'));
        $this->assertTrue($command->getDefinition()->hasOption('slug'));
    }

    public function testCanSuccessfulExecute()
    {
         $broker = $this
            ->getMockBuilder(Broker::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $broker
            ->expects($this->once())
            ->method('execute');

        $app = new Application;
        $app['broker'] = $broker;

        $output = new StreamOutput(fopen('php://memory', 'w', false));
        $input = new ArrayInput([
            'file' => __DIR__ . '/../Fixtures/coverage.xml'
        ]);

        $command = new AddCommand($app);
        $result = $command->run($input, $output);

        rewind($output->getStream());

        $this->assertEquals(0, $result);
        $this->assertRegExp(
            '/added and data are saved\!/',
            stream_get_contents($output->getStream())
        );
    }

    public function testUnexpectedFileThrowsError()
    {
        $broker = $this
            ->getMockBuilder(Broker::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMock();

        $broker
            ->expects($this->once())
            ->method('execute')
            ->willThrowException(UnsupportedException::create(new \SplFileInfo('unexpected')));

        $app = new Application;
        $app['broker'] = $broker;

        $output = new StreamOutput(fopen('php://memory', 'w', false));
        $input = new ArrayInput([
            'file' => __DIR__ . '/../Fixtures/coverage.xml'
        ]);

        $command = new AddCommand($app);
        $result = $command->run($input, $output);

        rewind($output->getStream());

        $this->assertEquals(1, $result);
        $this->assertRegExp(
            '/seems not supported\!/',
            stream_get_contents($output->getStream())
        );
    }
}
