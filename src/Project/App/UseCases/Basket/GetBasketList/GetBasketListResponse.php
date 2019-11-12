<?php


namespace App\Project\App\UseCases\Basket\GetBasketList;


use App\Project\Domain\Basket\Entity\Basket\Basket;

class GetBasketListResponse
{
    private $basketList;

    public function __construct(Basket ...$basketList)
    {
        $this->basketList = $basketList;
    }

    /**
     * @return Basket[]
     */
    public function basketList(): array
    {
        return $this->basketList;
    }
}
