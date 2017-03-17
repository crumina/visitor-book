<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package AppBundle\Repository
 */
class NoteRepository extends EntityRepository
{
    /**
     * @param int $limit
     * @return mixed
     */
    public function findNewestNotes($limit = 5)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT n FROM AppBundle:Note n ORDER BY n.created_at DESC'
            )
            ->setMaxResults($limit)
            ->getResult();
    }

    /**
     * @param int $limit
     * @return array
     */
    public function findOldestNotes($limit = 1)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT n FROM AppBundle:Note n ORDER BY n.created_at ASC'
            )
            ->setMaxResults($limit)
            ->getResult();
    }
}