<?php


namespace App\Project\Domain\Basket\Exceptions\Basket;

use DomainException;

class BasketCapacityExceedException extends DomainException
{
    private const MESSAGE = 'This basket free capacity is insufficient to add this item';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
