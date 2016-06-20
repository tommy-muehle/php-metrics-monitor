<?php

namespace MetricsMonitor\Tests\Service;

use MetricsMonitor\Model\Data;
use MetricsMonitor\Schema\CoverageMigration;
use MetricsMonitor\Schema\Migrator;
use MetricsMonitor\Service\Storage;
use MetricsMonitor\Service\Storage\StorageFinder;
use MetricsMonitor\Service\Storage\StoragePersister;
use MetricsMonitor\Tests\Utility\SqliteUtility;

/**
 * @package MetricsMonitor\Tests\Service
 */
class StorageTest extends \PHPUnit_Framework_TestCase
{
    use SqliteUtility;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $connection = $this->getConnection();

        $migrator = new Migrator($connection);
        $migrator->migrate([
            new CoverageMigration,
        ]);

        $this->storage = new Storage(
            new StorageFinder($connection),
            new StoragePersister($connection)
        );
    }

    public function testCanPersistAndFindCoverageData()
    {
        $coverage = [
            new Data('coverage', new \DateTime('2016-06-09 18:00:00'), 74.0, 'PROJ1'),
            new Data('coverage', new \DateTime('2016-06-10 18:00:00'), 76.0, 'PROJ1'),
            new Data('coverage', new \DateTime('2016-06-10 19:00:00'), 80.0, 'PROJ2'),
        ];

        foreach ($coverage as $data) {
            $this->storage->persist('coverage', $data);
        }

        $entries = $this->storage->findCoverageData();
        $this->assertCount(3, $entries);

        $entries = $this->storage->findCoverageData('PROJ1');
        $this->assertCount(2, $entries);
    }
}
