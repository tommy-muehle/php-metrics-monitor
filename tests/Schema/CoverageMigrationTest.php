<?php

namespace MetricsMonitor\Tests\Schema;

use MetricsMonitor\Schema\CoverageMigration;
use MetricsMonitor\Tests\Utility\SqliteUtility;

/**
 * @package MetricsMonitor\Tests\Schema
 */
class CoverageMigrationTest extends \PHPUnit_Framework_TestCase
{
    use SqliteUtility;

    public function testCanMigrateSchema()
    {
        $schema = $this
            ->getConnection()
            ->getSchemaManager()
            ->createSchema();

        $this->assertFalse($schema->hasTable('coverage'));

        $migration = new CoverageMigration;
        $migration->updateSchema($schema);

        $this->assertTrue($schema->hasTable('coverage'));
        $this->assertCount(3, $schema->getTable('coverage')->getColumns());
    }

    public function testCorrectColumnsAreExist()
    {
        $schema = $this
            ->getConnection()
            ->getSchemaManager()
            ->createSchema();

        $migration = new CoverageMigration;
        $migration->updateSchema($schema);

        $table = $schema->getTable('coverage');

        $this->assertTrue($table->hasColumn('date'));
        $this->assertTrue($table->hasColumn('score'));
        $this->assertTrue($table->hasColumn('slug'));
    }
}
