<?php


namespace App\Project\Domain\Basket\Entity\Basket;


use App\Project\App\Support\ExtendedArrayCollection;
use App\Project\Domain\Basket\Entity\{
    Item\Item,
    Item\ItemDTO,
    Item\ItemId,
    Item\ItemType,
    Weight\Weight};
use App\Project\Domain\Basket\Exceptions\{
    Basket\BasketCapacityExceedException,
    Item\ItemNotFoundInBasketException,
    Weight\WeightLessZeroException};
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

    protected function contentsInternal(): ExtendedArrayCollection
    {
        if ($this->contents instanceof PersistentCollection) {
            return new ExtendedArrayCollection($this->contents->getValues());
        }
        return $this->contents;
    }

    public function contents(): ExtendedArrayCollection
    {
        return $this->contentsInternal()->map(function (Item $item) {
            return $item->convertToDTO();
        });
    }

    // TODO: remove later (as not DDD, infrastructure dependency) temporary solution allowing Doctrine collection cascade update
    protected function contentsPersist(): Collection
    {
        return $this->contents;
    }

    public function currentBasketWeight(): Weight
    {
        return $this->contentsInternal()->reduce(function (Weight $weight, Item $item) {
            return $weight->add($item->weight());
        }, new Weight(0));
    }

    protected function getItemByTypeInternal(ItemType $itemType): Item
    {
        $item = $this->contentsInternal()->firstWhen(function (Item $item) use ($itemType){
            return $item->type()->isSameType($itemType);
        });

        if(!$item){
            throw new ItemNotFoundInBasketException();
        }

        return $item;
    }

    public function getItemByType(ItemType $itemType): ItemDTO
    {
        return $this->getItemByTypeInternal($itemType)->convertToDTO();
    }

    public function removeContent(ItemId $id): ExtendedArrayCollection
    {
        $item = $this->contentsInternal()->firstWhen(function (Item $item) use ($id) {
            return $item->id()->equals($id);
        });

        if(!$item){
            throw new ItemNotFoundInBasketException();
        }

        $this->contentsPersist()->removeElement($item);

        return $this->contents();
    }

    public function addContent(ItemType $itemType, Weight $weight): ExtendedArrayCollection
    {
        $currentBasketWeight = $this->currentBasketWeight();

        try {
            $maxCapacity = $this->maxCapacity();
            $this->maxCapacity()
                ->deduct($currentBasketWeight)
                ->deduct($weight);
        } catch (WeightLessZeroException $e) {
            $message[] = 'maxCapacity: ' . $maxCapacity;
            $message[] = 'currentBasketWeight: ' . $currentBasketWeight;
            $message[] = 'newItemsWeight: ' . $weight;
            throw new BasketCapacityExceedException(implode(', ',$message));
        }

        try {
            $this
                ->getItemByTypeInternal($itemType)
                ->addWeight($weight);
        } catch (ItemNotFoundInBasketException $e) {
            $this
                ->contentsPersist()
                ->add(
                    new Item(
                        ItemId::generate(),
                        $itemType,
                        $weight,
                        $this
                    )
                );
        }

        return $this->contents();
    }

    public function setName(BasketName $name): void
    {
        $this->name = $name;
    }
}
