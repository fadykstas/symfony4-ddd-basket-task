<?php


namespace App\Project\Infrastructure\Basket\Types;


use App\Project\Domain\Basket\Entity\Basket\BasketId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BasketIdType extends Type
{
    const TYPE_NAME = 'basket_id';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? BasketId::fromString($value) : $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function getName()
    {
        return self::TYPE_NAME;
    }
}
