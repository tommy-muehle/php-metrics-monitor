<?php

namespace MetricsMonitor\Service\Storage;

use Doctrine\DBAL\Connection;

abstract class AbstractStorage
{
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
