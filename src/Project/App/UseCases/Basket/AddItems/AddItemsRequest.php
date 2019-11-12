<?php


namespace App\Project\App\UseCases\Basket\AddItems;

use App\Project\App\Support\ExtendedArrayCollection;
use App\Project\Domain\Basket\Entity\{
    Basket\BasketId,
    Item\ItemType,
    Weight\Weight};

class AddItemsRequest
{
    private $itemDTOs = [];
    private $basketId;

    public function __construct(string $basketId, array $itemsData)
    {
        $this->itemDTOs = ExtendedArrayCollection::make($itemsData)->map(function ($item) {
            return new AddItemDTO(
                new ItemType($item->itemType),
                new Weight($item->weight)
            );
        })->getValues();
        $this->basketId = BasketId::fromString($basketId);
    }

    public function itemDTOs(): array
    {
        return $this->itemDTOs;
    }

    public function basketId(): BasketId
    {
        return $this->basketId;
    }

}
