<?php


namespace App\Project\App\UseCases\Basket\RemoveBasket;


use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;

class RemoveBasketAction
{
    private $basketRepository;

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function execute(RemoveBasketRequest $basketRequest): RemoveBasketResponse
    {
        $basket = $this->basketRepository->getById(
            $basketRequest->basketId()
        );
        $this->basketRepository->delete($basket);

        return new RemoveBasketResponse();

    }
}
