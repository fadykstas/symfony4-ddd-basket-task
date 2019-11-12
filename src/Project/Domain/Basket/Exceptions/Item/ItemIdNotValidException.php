<?php


namespace App\Project\Domain\Basket\Exceptions\Item;

use DomainException;

class ItemIdNotValidException extends DomainException
{
    private const MESSAGE = 'This item id is not valid';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
