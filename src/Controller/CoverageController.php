<?php

namespace MetricsMonitor\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package MetricsMonitor\Controller
 */
class CoverageController extends AbstractController
{
    /**
     * @param Application $app
     *
     * @return string
     */
    public function indexAction(Application $app)
    {
        $slugs = $app['storage']->findCoverageSlugs();

        return $this->render($app, 'coverage.html.twig', ['slugs' => $slugs]);
    }

    /**
     * @param Application $app
     * @param string      $slug
     *
     * @return JsonResponse
     */
    public function dataAction(Application $app, $slug)
    {
        $data = $app['storage']->findCoverageData($slug);
        $result = [];

        foreach ($data as $item) {
            $result[] = [
                'x' => $item['date'],
                'y' => $item['score'],
            ];
        }

        return new JsonResponse($result);
    }

    /**
     * @param Application $app
     *
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        /* @var $coverageController \Silex\ControllerCollection */
        $coverageController = $app['controllers_factory'];

        $coverageController
            ->match('/', [$this, 'indexAction'])
            ->bind('coverage.index');

        $coverageController
            ->match('/data/{slug}', [$this, 'dataAction'])
            ->bind('coverage.data');

        return $coverageController;
    }
}
