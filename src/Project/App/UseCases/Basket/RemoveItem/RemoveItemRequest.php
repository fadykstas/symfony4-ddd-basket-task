<?php


namespace App\Project\App\UseCases\Basket\RemoveItem;


use App\Project\Domain\Basket\Entity\Basket\BasketId;
use App\Project\Domain\Basket\Entity\Item\ItemType;

class RemoveItemRequest
{
    private $basketId;
    private $itemType;

    public function __construct(string $basketId, string $itemType)
    {
        $this->basketId = BasketId::fromString($basketId);
        $this->itemType = new ItemType($itemType);
    }

    public function basketId(): BasketId
    {
        return $this->basketId;
    }

    public function itemType(): ItemType
    {
        return $this->itemType;
    }
}
