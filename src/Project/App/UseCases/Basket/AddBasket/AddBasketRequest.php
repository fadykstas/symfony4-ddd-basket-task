<?php


namespace App\Project\App\UseCases\Basket\AddBasket;


class AddBasketRequest
{
    private $basketName;
    private $basketMaxCapacity;

    public function __construct(string $basketName, int $basketMaxCapacity)
    {

        $this->basketName = $basketName;
        $this->basketMaxCapacity = $basketMaxCapacity;
    }

    public function basketName(): string
    {
        return $this->basketName;
    }

    public function basketMaxCapacity(): int
    {
        return $this->basketMaxCapacity;
    }

}
