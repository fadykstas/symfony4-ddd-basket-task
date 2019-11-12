<?php


namespace App\Project\Domain\Basket\Exceptions\Basket;

use DomainException;

class BasketIdNotValidException extends DomainException
{
    private const MESSAGE = 'This basket id is not valid';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
