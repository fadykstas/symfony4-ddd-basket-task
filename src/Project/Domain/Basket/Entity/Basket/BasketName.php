<?php


namespace App\Project\Domain\Basket\Entity\Basket;


use App\Project\Domain\Basket\Exceptions\Item\BasketNameEmptyException;

class BasketName
{
    private $name;

    public function __construct(string $name)
    {
        if (strlen($name) === 0)
            throw new BasketNameEmptyException();

        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
