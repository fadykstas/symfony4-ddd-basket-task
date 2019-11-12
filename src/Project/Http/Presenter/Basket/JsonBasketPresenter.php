<?php

namespace App\Project\Http\Presenter\Basket;

use App\Project\App\Support\ExtendedArrayCollection;
use App\Project\Domain\Basket\Entity\Basket\Basket;
use App\Project\Domain\Basket\Entity\Item\Item;

class JsonBasketPresenter
{
    private $jsonItemPresenter;

    public function __construct(JsonItemPresenter $jsonItemPresenter)
    {
        $this->jsonItemPresenter = $jsonItemPresenter;
    }

    public function presentBasketShort(Basket $basket): array
    {
        return [
            "id" => $basket->id()->id(),
            "name" => $basket->name()->name(),
            "maxCapacity" => $basket->maxCapacity()->weight(),
        ];
    }

    public function presentBasketFull(Basket $basket): array
    {
        return [
            "id" => $basket->id()->id(),
            "name" => $basket->name()->name(),
            "maxCapacity" => $basket->maxCapacity()->weight(),
            "contents" => $basket->contents()->map(function (Item $item) {
                return $this->jsonItemPresenter->presentItemShort($item);
            })->getValues()
        ];
    }

    public function presentBasketListShort(array $basketList): array
    {
        return ExtendedArrayCollection::make($basketList)->map(function (Basket $basket) {
            return $this->presentBasketShort($basket);
        })->getValues();
    }

    public function presentBasketListFull(array $basketList): array
    {
        return ExtendedArrayCollection::make($basketList)->map(function (Basket $basket) {
            return $this->presentBasketFull($basket);
        })->getValues();
    }
}
