<?php


namespace App\Project\App\UseCases\Basket\RenameBasket;


use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;
use App\Project\Domain\Basket\Entity\Basket\BasketName;

class RenameBasketAction
{
    private $basketRepository;

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function execute(RenameBasketRequest $basketRequest): RenameBasketResponse
    {
        $basket = $this->basketRepository->getById(
            $basketRequest->basketId()
        );
        $basket->setName(new BasketName($basketRequest->newBasketName()));
        $this->basketRepository->save($basket);
        $basket = $this->basketRepository->getById($basket->id());

        return new RenameBasketResponse($basket);
    }
}
