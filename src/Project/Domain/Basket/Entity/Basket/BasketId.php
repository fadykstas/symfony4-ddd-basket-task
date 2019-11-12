<?php


namespace App\Project\Domain\Basket\Entity\Basket;

use App\Project\Domain\Basket\Exceptions\Basket\BasketIdNotValidException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


class BasketId
{
    protected $id;

    private function __construct(UuidInterface $uuid)
    {
        $this->id = $uuid;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return BasketId
     * @throws \Exception
     */
    public static function generate(): BasketId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $itemId): BasketId
    {
        try {
            $uuid = Uuid::fromString($itemId);
        } catch (InvalidUuidStringException $e) {
            throw new BasketIdNotValidException();
        }
        return new BasketId($uuid);
    }
}
