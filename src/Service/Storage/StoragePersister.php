<?php

namespace MetricsMonitor\Service\Storage;

use Doctrine\DBAL\DBALException;
use MetricsMonitor\Model\Data;

/**
 * @package MetricsMonitor\Service\Storage
 */
class StoragePersister extends AbstractStorage
{
    /**
     * @param string $table
     * @param Data   $data
     */
    public function persist($table, Data $data)
    {
        $this->insert($table, [
            'slug' => $data->getSlug(),
            'date' => $data->getDate()->format('Y-m-d H:i:s'),
            'score' => $data->getScore(),
        ]);
    }

    /**
     * @param string $table
     * @param array  $data
     *
     * @throws \Doctrine\DBAL\ConnectionException
     */
    private function insert($table, array $data)
    {
        $this->connection->beginTransaction();

        try {
            $this->connection->insert($table, $data);
            $this->connection->commit();
        } catch (DBALException $exception) {
            $this->connection->rollBack();
        }
    }
}
