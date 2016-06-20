<?php

namespace MetricsMonitor\Tests\Utility;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

/**
 * @package MetricsMonitor\Tests\Utility
 */
trait SqliteUtility
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @return \Doctrine\DBAL\Connection
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function getConnection()
    {
        $parameters = [
            'memory' => true,
            'driver' => 'pdo_sqlite',
        ];

        return DriverManager::getConnection($parameters, new Configuration);
    }
}
