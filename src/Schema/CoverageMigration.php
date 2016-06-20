<?php

namespace MetricsMonitor\Schema;

use Doctrine\DBAL\Schema\Schema;

/**
 * @package MetricsMonitor\Schema
 */
class CoverageMigration implements MigrationInterface
{
    /**
     * @param Schema $schema
     */
    public function updateSchema(Schema $schema)
    {
        if (true === $schema->hasTable('coverage')) {
            return;
        }

        $table = $schema->createTable('coverage');
        $table->addColumn('slug', 'string', [
            'notnull' => true
        ]);
        $table->addColumn('score', 'float');
        $table->addColumn('date', 'datetime', [
            'notnull' => true,
        ]);
    }
}
