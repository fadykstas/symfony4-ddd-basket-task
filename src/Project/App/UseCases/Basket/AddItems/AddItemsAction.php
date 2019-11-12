<?php


namespace App\Project\App\UseCases\Basket\AddItems;


use App\Project\App\Support\ExtendedArrayCollection;
use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;
use App\Project\Domain\Basket\Entity\Basket\Basket;
use App\Project\Domain\Basket\Entity\Item\Item;
use App\Project\Domain\Basket\Entity\Item\ItemId;

class AddItemsAction
{
    private $basketRepository;

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function execute(AddItemsRequest $itemsRequest): AddItemsResponse
    {
        /** @var Basket $basket */
        $basket = $this->basketRepository->getById($itemsRequest->basketId());
        $itemsToAdd = ExtendedArrayCollection
            ::make($itemsRequest->itemDTOs())
            ->map(function (AddItemDTO $dto) use ($basket) {
               return new Item(
                   ItemId::generate(),
                   $dto->itemType(),
                   $dto->weight(),
                   $basket
               );
            })->getValues();
        $basket->addContents(...$itemsToAdd);

        $this->basketRepository->save($basket);
        $basket = $this->basketRepository->getById($basket->id());

        return new AddItemsResponse($basket);
    }
}
