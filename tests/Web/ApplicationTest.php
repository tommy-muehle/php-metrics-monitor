<?php

namespace MetricsMonitor\Tests\Web;

use MetricsMonitor\Web\Application;
use Silex\Controller;

/**
 * @package MetricsMonitor\Tests\Web
 */
class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiredServicesAreExist()
    {
        $app = new Application;

        $this->assertInstanceOf(\Twig_Environment::class, $app['twig']);
    }

    public function testControllersAreExist()
    {
        $app = new Application;

        $this->assertInstanceOf(Controller::class, $app['controllers']->get('/'));
        $this->assertInstanceOf(Controller::class, $app['controllers']->get('/coverage'));
    }
}
