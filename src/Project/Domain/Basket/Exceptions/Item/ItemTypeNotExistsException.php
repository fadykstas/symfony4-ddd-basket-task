<?php


namespace App\Project\Domain\Basket\Exceptions\Item;

use DomainException;

class ItemTypeNotExistsException extends DomainException
{
    private const MESSAGE = 'This item type not exists';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
