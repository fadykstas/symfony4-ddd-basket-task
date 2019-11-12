<?php


namespace App\Project\App\UseCases\Basket\GetBasket;


use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;

class GetBasketAction
{
    private $basketRepository;

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function execute(GetBasketRequest $basketRequest): GetBasketResponse
    {
        $basket = $this->basketRepository->getById(
            $basketRequest->basketId()
        );

        return new GetBasketResponse($basket);

    }
}
