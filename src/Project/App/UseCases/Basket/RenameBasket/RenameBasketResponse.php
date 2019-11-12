<?php


namespace App\Project\App\UseCases\Basket\RenameBasket;


use App\Project\Domain\Basket\Entity\Basket\Basket;

class RenameBasketResponse
{
    private $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function basket(): Basket
    {
        return $this->basket;
    }
}
