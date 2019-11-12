<?php


namespace App\Project\App\UseCases\Basket\GetBasket;


use App\Project\Domain\Basket\Entity\Basket\Basket;

class GetBasketResponse
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
