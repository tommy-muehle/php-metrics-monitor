<?php

namespace MetricsMonitor\Provider;

use Doctrine\DBAL\Connection;
use MetricsMonitor\Service\Storage;
use MetricsMonitor\Service\Storage\StorageFinder;
use MetricsMonitor\Service\Storage\StoragePersister;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * @package MetricsMonitor\Provider
 */
class StorageServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     *
     * @throws \Exception
     */
    public function register(Application $app)
    {
        if (!$app['db'] instanceof Connection) {
            throw new \Exception('Connection are required!');
        }

        $app['storage'] = $app->share(function () use ($app) {
            return new Storage(
                new StorageFinder($app['db']),
                new StoragePersister($app['db'])
            );
        });
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}
