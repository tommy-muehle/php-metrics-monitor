<?php

namespace MetricsMonitor\Controller;

use Silex\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package MetricsMonitor\Controller
 */
class DefaultController extends AbstractController implements ControllerProviderInterface
{
    /**
     * @param Application $app
     *
     * @return string
     */
    public function indexAction(Application $app)
    {
        $parsedown = new \Parsedown;

        $variables = [
            'version' => $app['version'],
            'readme' => $parsedown->text(file_get_contents(__DIR__ . '/../../README.md')),
        ];

        return $this->render($app, 'default.html.twig', $variables);
    }

    /**
     * @param Application $app
     * @param string      $file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function cssAction(Application $app, $file)
    {
        $filename = sprintf(__DIR__ . '/../../public/resources/css/%s', $file);

        return $this->sendFile($app, $filename, 'text/css');
    }

    /**
     * @param Application $app
     * @param string      $file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function jsAction(Application $app, $file)
    {
        $filename = sprintf(__DIR__ . '/../../public/resources/js/%s', $file);

        return $this->sendFile($app, $filename, 'text/javascript');
    }

    /**
     * @param Application $app
     *
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        $controller = $app['controllers_factory'];

        /* @var $controller \Silex\ControllerCollection */
        $controller
            ->match('/', [$this, 'indexAction'])
            ->bind('default.index');

        $controller
            ->match('/css/{file}', [$this, 'cssAction'])
            ->bind('default.css');

        $controller
            ->match('/js/{file}', [$this, 'jsAction'])
            ->bind('default.js');

        return $controller;
    }

    /**
     * @param Application $app
     * @param string      $filename
     * @param string      $contentType
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function sendFile(Application $app, $filename, $contentType = 'text/plain')
    {
        if (false === file_exists($filename)) {
            $app->abort(Response::HTTP_NOT_FOUND);
        }

        return $app->sendFile($filename, Response::HTTP_OK, ['content-type' => $contentType]);
    }
}
