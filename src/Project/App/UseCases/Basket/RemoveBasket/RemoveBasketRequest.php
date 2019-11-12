<?php


namespace App\Project\App\UseCases\Basket\RemoveBasket;


use App\Project\Domain\Basket\Entity\Basket\BasketId;

class RemoveBasketRequest
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
