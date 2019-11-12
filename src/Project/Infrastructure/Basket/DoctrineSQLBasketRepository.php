<?php


namespace App\Project\Infrastructure\Basket;

use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;
use App\Project\Domain\Basket\Entity\Basket\Basket;
use App\Project\Domain\Basket\Entity\Basket\BasketId;
use App\Project\Domain\Basket\Exceptions\Basket\BasketNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DoctrineSQLBasketRepository extends ServiceEntityRepository implements BasketRepositoryInterface
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Basket::class);
    }

    public function getBaskets(): array
    {
        $baskets = $this->findAll();
        return $baskets;
    }


    /**
     * @param Basket $basket
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Basket $basket): void
    {
        $this->_em->persist($basket);
        $this->_em->flush();
    }


    public function getById(BasketId $basketId): Basket
    {
        $basket = $this->find($basketId);
        if (!$basket)
            throw new BasketNotFoundException();
        /** @var Basket $basket */
        return $basket;
    }


    /**
     * @param Basket $basket
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Basket $basket): void
    {
        $this->_em->remove($basket);
        $this->_em->flush();
    }
}
