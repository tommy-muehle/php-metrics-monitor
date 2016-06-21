<?php

namespace MetricsMonitor\Service\Storage;

use Doctrine\DBAL\Connection;

/**
 * @package MetricsMonitor\Service\Storage
 */
abstract class AbstractStorage
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
