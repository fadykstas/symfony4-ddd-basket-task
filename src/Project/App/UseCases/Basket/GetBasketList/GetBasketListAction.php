<?php


namespace App\Project\App\UseCases\Basket\GetBasketList;


use App\Project\Domain\Basket\Contract\BasketRepositoryInterface;

class GetBasketListAction
{
    private $basketRepository;

    public function __construct(BasketRepositoryInterface $basketRepository)
    {
        $this->basketRepository = $basketRepository;
    }

    public function execute(GetBasketListRequest $basketListRequest): GetBasketListResponse
    {
        $basketList = $this->basketRepository->getBaskets();

        return new GetBasketListResponse(...$basketList);

    }
}
