<?php


namespace App\Project\App\UseCases\Basket\AddBasket;


use App\Project\Domain\Basket\Entity\Basket\Basket;

class AddBasketResponse
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
