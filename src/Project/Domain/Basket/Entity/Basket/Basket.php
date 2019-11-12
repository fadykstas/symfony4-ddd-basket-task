<?php


namespace App\Project\Domain\Basket\Entity\Basket;


use App\Project\App\Support\ExtendedArrayCollection;
use App\Project\Domain\Basket\Entity\Item\Item;
use App\Project\Domain\Basket\Entity\Item\ItemType;
use App\Project\Domain\Basket\Entity\Weight\Weight;
use App\Project\Domain\Basket\Exceptions\Basket\BasketCapacityExceedException;
use App\Project\Domain\Basket\Exceptions\Item\ItemNotFoundInBasketException;
use App\Project\Domain\Basket\Exceptions\Weight\WeightLessZeroException;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;


class Basket
{
    private $id;
    private $name;
    private $maxCapacity;
    private $contents;

    public function __construct(BasketId $id, BasketName $name, Weight $maxCapacity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->maxCapacity = $maxCapacity;
        $this->contents = new ExtendedArrayCollection();
    }

    public function id(): BasketId
    {
        return $this->id;
    }

    public function name(): BasketName
    {
        return $this->name;
    }

    public function maxCapacity(): Weight
    {
        return $this->maxCapacity;
    }

    public function contents(): ExtendedArrayCollection
    {
        if ($this->contents instanceof PersistentCollection) {
            return new ExtendedArrayCollection($this->contents->getValues());
        }
        return $this->contents;
    }

    // TODO: remove later (as not DDD, infrastructure dependency) temporary solution allowing Doctrine collection cascade update
    public function contentsPersist(): Collection
    {
        return $this->contents;
    }

    public function currentBasketWeight(): Weight
    {
        return $this->contents()->reduce(function (Weight $weight, Item $item) {
            return $weight->add($item->weight());
        }, new Weight(0));
    }

    public function getItemByType(ItemType $itemType): Item {
        $item = $this->contents()->firstWhen(function (Item $item) use ($itemType){
            return $item->type()->isSameType($itemType);
        });

        if(!$item){
            throw new ItemNotFoundInBasketException();
        }

        return $item;
    }

    public function removeContent(Item $itemToRemove): ExtendedArrayCollection
    {
        $this->contentsPersist()->removeElement($itemToRemove);

        return $this->contents();
    }

    public function addContents(Item ...$items): ExtendedArrayCollection
    {
        $currentBasketWeight = $this->currentBasketWeight();
        $newItemsCollection = new ExtendedArrayCollection($items);

        $newItemsWeight = $newItemsCollection
            ->reduce(function (Weight $weight, Item $item) {
                return $weight->add($item->weight());
            }, new Weight());

        try {
            $maxCapacity = $this->maxCapacity();
            $this->maxCapacity()
                ->deduct($currentBasketWeight)
                ->deduct($newItemsWeight);
        } catch (WeightLessZeroException $e) {
            $message[] = 'maxCapacity: ' . $maxCapacity;
            $message[] = 'currentBasketWeight: ' . $currentBasketWeight;
            $message[] = 'newItemsWeight: ' . $newItemsWeight;
            throw new BasketCapacityExceedException(implode(', ',$message));
        }

        $newItemsCollection->map(function (Item $item) {
            try {
                $this
                    ->getItemByType($item->type())
                    ->addWeight($item->weight());
            } catch (ItemNotFoundInBasketException $e) {
                $this
                    ->contentsPersist()
                    ->add($item);
            }
        });

        return $this->contents();
    }

    public function setName(BasketName $name): void
    {
        $this->name = $name;
    }
}
