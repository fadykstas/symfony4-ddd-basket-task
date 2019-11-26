<?php


namespace App\Project\App\UseCases\Basket\RemoveItem;


use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;
use App\Project\Domain\Basket\Entity\Item\ItemDTO;


class RemoveItemAction
{
    private $basketRepository;

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function execute(RemoveItemRequest $itemsRequest): RemoveItemResponse
    {
        $basket = $this->basketRepository->getById($itemsRequest->basketId());
        /** @var ItemDTO $item */
        $item = $basket->getItemByType($itemsRequest->itemType());
        $basket->removeContent($item->id());

        $this->basketRepository->save($basket);
        $basket = $this->basketRepository->getById($basket->id());

        return new RemoveItemResponse($basket);
    }
}
