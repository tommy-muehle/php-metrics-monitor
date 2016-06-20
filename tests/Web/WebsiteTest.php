<?php

namespace MetricsMonitor\Tests\Web;

use MetricsMonitor\Web\Application;
use Silex\WebTestCase;

/**
 * @package MetricsMonitor\Tests\Web
 */
class WebsiteTest extends WebTestCase
{
    public function testInitialPageAreAccessible()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(2, $crawler->filterXPath('//h1'));
    }

    public function testCanAccessCoveragePage()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/coverage/');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertCount(1, $crawler->filterXPath('//canvas'));
    }

    public function testCanGetCssFiles()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/css/page.css');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals(
            'text/css',
            $client->getResponse()->headers->get('content-type')
        );
    }

    public function testCanGetJsFiles()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/js/moment.min.js');

        $this->assertTrue($client->getResponse()->isOk());
        $this->assertEquals(
            'text/javascript', $client->getResponse()->headers->get('content-type')
        );
    }

    public function testInaccessibleFileReturnsNotFound()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/js/not.exist.js');

        $this->assertTrue($client->getResponse()->isNotFound());
    }

    /**
     * @return Application
     */
    public function createApplication()
    {
        return new Application;
    }
}
