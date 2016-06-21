<?php

namespace MetricsMonitor;

use MetricsMonitor\Provider\StorageServiceProvider;
use MetricsMonitor\Schema\CoverageMigration;
use MetricsMonitor\Schema\Migrator;
use Silex\Application as BaseApplication;
use Silex\Provider\DoctrineServiceProvider;

/**
 * @package MetricsMonitor
 */
abstract class Application extends BaseApplication
{
    /**
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this['version'] = '1.0.1';

        $this->register(new DoctrineServiceProvider, ['db.options' => [
            'dbname' => 'data',
            'driver' => 'pdo_sqlite',
            'path' => getenv('HOME') . '/.memo.db',
        ]]);

        $this->register(new StorageServiceProvider);

        $migrator = new Migrator($this['db']);
        $migrator->migrate([
            new CoverageMigration,
        ]);
    }
}
