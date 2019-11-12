<?php


namespace App\Project\App\UseCases\Basket\AddItems;


use App\Project\Domain\Basket\Entity\Item\ItemType;
use App\Project\Domain\Basket\Entity\Weight\Weight;

class AddItemDTO
{
    private $itemType;
    private $weight;

    public function __construct(ItemType $itemType, Weight $weight)
    {
        $this->itemType = $itemType;
        $this->weight = $weight;
    }

    public function itemType(): ItemType
    {
        return $this->itemType;
    }

    public function weight(): Weight
    {
        return $this->weight;
    }
}
