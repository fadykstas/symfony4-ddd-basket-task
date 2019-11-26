<?php


namespace App\Project\Domain\Basket\Entity\Item;


use App\Project\Domain\Basket\Entity\Basket\Basket;
use App\Project\Domain\Basket\Entity\Weight\Weight;

class ItemDTO
{
    private $id;
    private $type;
    private $weight;
    private $basket;

    public function __construct(ItemId $id, ItemType $type, Weight $weight, Basket $basket = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->weight = $weight;
        $this->basket = $basket;
    }

    public function id(): ItemId
    {
        return $this->id;
    }

    public function type(): ItemType
    {
        return $this->type;
    }

    public function weight(): Weight
    {
        return $this->weight;
    }

    public function basket(): Basket
    {
        return $this->basket;
    }

    public function __toString()
    {
        return $this->type() . ' ' . $this->weight;
    }
}
