<?php


namespace App\Project\App\UseCases\Basket\GetBasket;


use App\Project\Domain\Basket\Entity\Basket\BasketId;

class GetBasketRequest
{
    private $basketId;

    public function __construct(string $basketId)
    {
        $this->basketId = BasketId::fromString($basketId);
    }

    public function basketId(): BasketId
    {
        return $this->basketId;
    }
}
