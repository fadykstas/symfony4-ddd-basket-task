<?php


namespace App\Project\Domain\Basket\Exceptions\Weight;

use DomainException;

class WeightLessZeroException extends DomainException
{
    private const MESSAGE = 'Weight must be grater than zero';

    public function __construct(string $message = self::MESSAGE)
    {
        parent::__construct($message);
    }
}
