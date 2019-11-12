<?php


namespace App\Project\Domain\Basket\Exceptions\Item;

use DomainException;

class ItemNotFoundInBasketException extends DomainException
{
    private const MESSAGE = 'This item not found in basket';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
