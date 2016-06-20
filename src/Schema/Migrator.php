<?php

namespace MetricsMonitor\Schema;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

/**
 * @package MetricsMonitor\Schema
 */
class Migrator
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $migrations
     */
    public function migrate(array $migrations)
    {
        $fromSchema = $this->connection->getSchemaManager()->createSchema();
        $toSchema = clone $fromSchema;

        foreach ($migrations as $class) {
            $migration = new $class;

            if (!$migration instanceof MigrationInterface) {
                continue;
            }

            $migration->updateSchema($toSchema);
        }

        $this->buildSchema($fromSchema, $toSchema);
    }

    /**
     * @param Schema $fromSchema
     * @param Schema $toSchema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    private function buildSchema(Schema $fromSchema, Schema $toSchema)
    {
        $queries = $fromSchema->getMigrateToSql(
            $toSchema, $this->connection->getDatabasePlatform()
        );

        foreach ($queries as $query) {
            $this->connection->exec($query);
        }
    }
}
