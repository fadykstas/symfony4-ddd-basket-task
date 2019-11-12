<?php


namespace App\Project\Domain\Basket\Exceptions\Basket;

use DomainException;

class BasketNotFoundException extends DomainException
{
    private const MESSAGE = 'Basket not found';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
