<?php


namespace App\Project\Domain\Basket\Entity\Item;

use App\Project\Domain\Basket\Exceptions\Item\ItemIdNotValidException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ItemId
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

    public static function generate(): ItemId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $itemId): ItemId
    {
        try {
            $uuid = Uuid::fromString($itemId);
        } catch (InvalidUuidStringException $e) {
            throw new ItemIdNotValidException();
        }
        return new self($uuid);
    }
}
