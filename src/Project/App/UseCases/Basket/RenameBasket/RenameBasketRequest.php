<?php


namespace App\Project\App\UseCases\Basket\RenameBasket;


use App\Project\Domain\Basket\Entity\Basket\BasketId;

class RenameBasketRequest
{
    private $basketId;
    private $newBasketName;

    public function __construct(string $basketId, string $newBasketName)
    {
        $this->basketId = BasketId::fromString($basketId);
        $this->newBasketName = $newBasketName;
    }

    public function basketId(): BasketId
    {
        return $this->basketId;
    }

    public function newBasketName(): string
    {
        return $this->newBasketName;
    }
}
