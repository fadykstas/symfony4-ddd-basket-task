<?php


namespace App\Project\Infrastructure\Basket;

use App\Project\App\Support\AppEntityRepository;
use App\Project\Domain\Basket\Entity\Item\Item;

class DoctrineSQLItemRepository extends AppEntityRepository
{

    public function getItems()
    {
        $qb = $this->createQueryBuilder('a');

        return $qb->getQuery();
    }


    /**
     * @param Item $item
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Item $item): void
    {
        $this->_em->persist($item);
        $this->_em->flush();
    }
}
