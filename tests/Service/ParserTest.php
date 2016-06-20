<?php

namespace MetricsMonitor\Tests\Service;

use MetricsMonitor\Model\Data;
use MetricsMonitor\Service\Parser;
use MetricsMonitor\Service\Parser\CoverageParser;

/**
 * @package MetricsMonitor\Tests\Service
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testCanParseCoverageData()
    {
        $parser = new Parser;
        $parser->add(new CoverageParser);

        $file = new \SplFileInfo(__DIR__ . '/../Fixtures/coverage.xml');
        $this->assertTrue($parser->supports($file));

        $data = $parser->parse($file);
        $this->assertInstanceOf(Data::class, $data);
        $this->assertEquals(66.07, $data->getScore());
        $this->assertEquals('2016-02-23', $data->getDate()->format('Y-m-d'));
    }
}
