<?php

namespace MetricsMonitor\Web;

use MetricsMonitor\Application as BaseApplication;
use MetricsMonitor\Controller\CoverageController;
use MetricsMonitor\Controller\DefaultController;
use Silex\Provider\TwigServiceProvider;

/**
 * @package MetricsMonitor\Web
 */
class Application extends BaseApplication
{
    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->register(new TwigServiceProvider, [
            'twig.path' => __DIR__ . '/../../public/resources/views',
            'twig.options' => ['strict_variables' => false]
        ]);

        // mount controllers
        $this->mount('/', new DefaultController);
        $this->mount('/coverage', new CoverageController);
    }
}
