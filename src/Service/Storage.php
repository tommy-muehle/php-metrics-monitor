<?php

namespace MetricsMonitor\Service;

use MetricsMonitor\Model\Data;
use MetricsMonitor\Service\Storage\StorageFinder;
use MetricsMonitor\Service\Storage\StoragePersister;

/**
 * @package MetricsMonitor\Service
 */
class Storage
{
    /**
     * @var StorageFinder
     */
    private $finder;

    /**
     * @var StoragePersister
     */
    private $persister;

    /**
     * @param StorageFinder    $finder
     * @param StoragePersister $persister
     */
    public function __construct(StorageFinder $finder, StoragePersister $persister)
    {
        $this->finder = $finder;
        $this->persister = $persister;
    }

    /**
     * @param string $table
     * @param Data   $data
     */
    public function persist($table, Data $data)
    {
        $this->persister->persist($table, $data);
    }

    /**
     * @param string $slug
     *
     * @return array
     */
    public function findCoverageData($slug = null)
    {
        return $this->finder->findCoverageData($slug);
    }

    /**
     * @return array
     */
    public function findCoverageSlugs()
    {
        return $this->finder->findCoverageSlugs();
    }
}
