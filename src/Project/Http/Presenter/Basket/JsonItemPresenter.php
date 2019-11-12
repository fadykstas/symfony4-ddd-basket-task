<?php

namespace App\Project\Http\Presenter\Basket;

use App\Project\Domain\Basket\Entity\Item\Item;

class JsonItemPresenter
{
    public function presentItemFull(Item $item): array
    {
        $result = [
            "id" => $item->id()->id(),
            "basket_id" => $item->basket()->id()->id(),
            "type" => $item->type()->name(),
            "weight" => $item->weight()->weight()
        ];

        return $result;
    }

    public function presentItemShort(Item $item): array
    {
        $result = [
            "id" => $item->id()->id(),
            "type" => $item->type()->name(),
            "weight" => $item->weight()->weight()
        ];

        return $result;
    }
}
