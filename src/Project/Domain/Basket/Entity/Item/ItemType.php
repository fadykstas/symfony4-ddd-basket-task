<?php


namespace App\Project\Domain\Basket\Entity\Item;


use App\Project\Domain\Basket\Exceptions\Item\ItemTypeNotExistsException;

class ItemType
{
    const ALLOWED_TYPES = [
            self::ALLOWED_TYPE_APPLE,
            self::ALLOWED_TYPE_ORANGE,
            self::ALLOWED_TYPE_WATERMELON
    ];

    const ALLOWED_TYPE_APPLE = 'apple';
    const ALLOWED_TYPE_ORANGE = 'orange';
    const ALLOWED_TYPE_WATERMELON = 'watermelon';


    private $name;

    public static function allowedKeys(): array
    {
        return array_keys(self::ALLOWED_TYPES);
    }

    public function __construct(string $name)
    {
        if (!in_array($name, self::ALLOWED_TYPES))
            throw new ItemTypeNotExistsException();

        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isSameType(ItemType $itemType): bool
    {
        return $this->name() == $itemType->name();
    }

    public function __toString()
    {
        return $this->name();
    }


}
