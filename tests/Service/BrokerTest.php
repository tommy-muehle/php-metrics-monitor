<?php

namespace MetricsMonitor\Tests\Service;

use MetricsMonitor\Model\Data;
use MetricsMonitor\Service\Broker;
use MetricsMonitor\Service\Storage;
use MetricsMonitor\Service\Storage\StorageFinder;
use MetricsMonitor\Service\Storage\StoragePersister;
use MetricsMonitor\Service\Parser;
use MetricsMonitor\Service\Parser\CoverageParser;
use MetricsMonitor\Tests\Utility\SqliteUtility;

/**
 * @package MetricsMonitor\Tests\Service
 */
class BrokerTest extends \PHPUnit_Framework_TestCase
{
    use SqliteUtility;

    /**
     * @expectedException \MetricsMonitor\Exception\ParserException
     */
    public function testUnexpectedFileThrowsException()
    {
        $connection = $this->getConnection();

        $parser = new Parser;
        $parser->add(new CoverageParser);

        $storage = new Storage(
            new StorageFinder($connection), new StoragePersister($connection)
        );

        $broker = new Broker($parser, $storage);
        $broker->execute(new \SplFileInfo(__DIR__ . '/../Fixtures/invalid_coverage.xml'));
    }

    public function testSupportedFileWorksWell()
    {
        $parser = new Parser;
        $parser->add(new CoverageParser);

        $storage = $this
            ->getMockBuilder(Storage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $storage
            ->expects($this->once())
            ->method('persist')
            ->with('coverage', $this->isInstanceOf(Data::class));

        /* @var $storage Storage */
        $broker = new Broker($parser, $storage);
        $broker->execute(new \SplFileInfo(__DIR__ . '/../Fixtures/coverage.xml'));
    }
}
