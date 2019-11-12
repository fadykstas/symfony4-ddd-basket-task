<?php


namespace App\Project\Domain\Basket\Exceptions\Item;

use DomainException;

class BasketNameEmptyException extends DomainException
{
    private const MESSAGE = 'Basket name cannot be empty';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
