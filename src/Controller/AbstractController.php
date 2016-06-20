<?php

namespace MetricsMonitor\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;

/**
 * @package MetricsMonitor\Controller
 */
abstract class AbstractController implements ControllerProviderInterface
{
    /**
     * @param Application $app
     *
     * @return \Silex\ControllerCollection
     */
    abstract public function connect(Application $app);

    /**
     * @param Application $app
     * @param string      $template
     * @param array       $variables
     *
     * @return string
     */
    protected function render(Application $app, $template, array $variables = [])
    {
        /* @var $twig \Twig_Environment */
        $twig = $app['twig'];

        return $twig->render($template, $variables);
    }
}
