<?php


namespace App\Project\Domain\Basket\Contract;


use App\Project\Domain\Basket\Entity\Basket\Basket;
use App\Project\Domain\Basket\Entity\Basket\BasketId;

interface BasketRepositoryInterface
{
    public function getById(BasketId $basketId): Basket;

    public function getBaskets(): array;

    public function save(Basket $basket): void;

    public function delete(Basket $basket): void;
}
