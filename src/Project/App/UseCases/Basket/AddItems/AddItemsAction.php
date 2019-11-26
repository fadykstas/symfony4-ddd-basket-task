<?php


namespace App\Project\App\UseCases\Basket\AddItems;


use App\Project\App\Support\ExtendedArrayCollection;
use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;
use App\Project\Domain\Basket\Entity\Basket\Basket;

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
        ExtendedArrayCollection
            ::make($itemsRequest->itemDTOs())
            ->map(function (AddItemDTO $dto) use ($basket) {
                $basket->addContent(
                    $dto->itemType(),
                    $dto->weight()
                );
            });

        $this->basketRepository->save($basket);
        $basket = $this->basketRepository->getById($basket->id());

        return new AddItemsResponse($basket);
    }
}
