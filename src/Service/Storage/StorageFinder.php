<?php

namespace MetricsMonitor\Service\Storage;

/**
 * @package MetricsMonitor\Service\Storage
 */
class StorageFinder extends AbstractStorage
{
    /**
     * @return array
     */
    public function findCoverageSlugs()
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('slug')
            ->from('coverage')
            ->groupBy('slug');

        $statement = $queryBuilder->execute();

        return $statement->fetchAll();
    }

    /**
     * @param string $slug
     *
     * @return array
     */
    public function findCoverageData($slug = null)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('coverage')
            ->orderBy('date', 'ASC');

        if (null !== $slug) {
            $queryBuilder
                ->where('slug = :slug')
                ->setParameter('slug', $slug);
        }

        $statement = $queryBuilder->execute();

        return $statement->fetchAll();
    }
}
