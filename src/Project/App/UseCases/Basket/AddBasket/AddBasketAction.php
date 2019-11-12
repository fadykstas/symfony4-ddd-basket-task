<?php


namespace App\Project\App\UseCases\Basket\AddBasket;


use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;
use App\Project\Domain\Basket\Entity\Basket\Basket;
use App\Project\Domain\Basket\Entity\Basket\BasketId;
use App\Project\Domain\Basket\Entity\Basket\BasketName;
use App\Project\Domain\Basket\Entity\Weight\Weight;

class AddBasketAction
{
    private $basketRepository;

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function execute(AddBasketRequest $basketRequest): AddBasketResponse
    {
        $basket = new Basket(
            BasketId::generate(),
            new BasketName($basketRequest->basketName()),
            new Weight($basketRequest->basketMaxCapacity())
        );
        $this->basketRepository->save($basket);
        $basket = $this->basketRepository->getById($basket->id());

        return new AddBasketResponse($basket);
    }
}
