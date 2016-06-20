<?php

namespace MetricsMonitor\Schema;

use Doctrine\DBAL\Schema\Schema;

/**
 * @package MetricsMonitor\Schema
 */
interface MigrationInterface
{
    /**
     * @param Schema $schema
     */
    public function updateSchema(Schema $schema);
}
