<?php


namespace App\Project\Domain\Basket\Entity\Item;

use App\Project\Domain\Basket\Exceptions\Item\ItemIdNotValidException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Exception;

class ItemId
{
    protected $id;

    private function __construct(UuidInterface $uuid)
    {
        $this->id = $uuid;
    }

    public function equals(ItemId $id): bool
    {
        return $this->id() === $id->id();
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
        try {
            return new self(Uuid::uuid4());
        } catch (Exception $e) {
            throw new ItemIdNotValidException();
        }
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
