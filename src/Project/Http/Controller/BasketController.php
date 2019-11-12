<?php

namespace App\Project\Http\Controller;

use App\Project\App\UseCases\Basket\AddBasket\{
    AddBasketAction,
    AddBasketRequest};
use App\Project\App\UseCases\Basket\RemoveBasket\RemoveBasketAction;
use App\Project\App\UseCases\Basket\RemoveBasket\RemoveBasketRequest;
use App\Project\App\UseCases\Basket\RenameBasket\RenameBasketAction;
use App\Project\App\UseCases\Basket\RenameBasket\RenameBasketRequest;
use App\Project\App\UseCases\Basket\GetBasket\{
    GetBasketAction,
    GetBasketRequest};
use App\Project\App\UseCases\Basket\GetBasketList\{
    GetBasketListAction,
    GetBasketListRequest};
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Request};
use App\Project\Http\{
    Presenter\Basket\JsonBasketPresenter,
    Controller\Traits\JsonResponseTrait};
use DomainException;
use Swagger\Annotations as SWG;

class BasketController
{
    use JsonResponseTrait;

    private $getBasketListAction;
    private $getBasketAction;
    private $jsonBasketPresenter;
    private $addBasketAction;
    private $removeBasketAction;
    private $renameBasketAction;

    public function __construct(
       GetBasketListAction $getBasketListAction,
       GetBasketAction $getBasketAction,
       AddBasketAction $addBasketAction,
       RemoveBasketAction $removeBasketAction,
       RenameBasketAction $renameBasketAction,
       JsonBasketPresenter $jsonBasketPresenter
    ) {
        $this->getBasketListAction = $getBasketListAction;
        $this->jsonBasketPresenter = $jsonBasketPresenter;
        $this->getBasketAction = $getBasketAction;
        $this->addBasketAction = $addBasketAction;
        $this->removeBasketAction = $removeBasketAction;
        $this->renameBasketAction = $renameBasketAction;
    }
    /**
     * @param Request $request
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="returns the basket collection"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="returns error"
     * )
     * @SWG\Tag(name="baskets")
     */
    public function index()
    {
        try {
            $baskets = $this->getBasketListAction->execute(
                new GetBasketListRequest()
            );

            $array = $baskets->basketList();
            $json = $this->jsonBasketPresenter->presentBasketListShort($array);

            return $this->successResponseWithMeta($json);

        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="returns single basket"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="returns error"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     required=true,
     *     description="basket id from GET /baskets"
     * )
     * @SWG\Tag(name="baskets")
     */
    public function getBasket($id)
    {
        try {
            $basketResponse = $this->getBasketAction->execute(
                new GetBasketRequest($id)
            );

            $json = $this->jsonBasketPresenter->presentBasketFull($basketResponse->basket());

            return $this->successResponseWithMeta($json);

        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="returns updated basket"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="returns error"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="Name and max capacity of new basket",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="name",
     *             type="string",
     *             example="Basket #1"
     *         ),
     *         @SWG\Property(
     *             property="maxCapaicty",
     *             type="integer",
     *             example=170
     *         )
     *     )
     * )
     * @SWG\Tag(name="baskets")
     */
    public function addBasket(Request $request)
    {
        try {
            $request = json_decode($request->getContent());
            $basketResponse = $this->addBasketAction->execute(
                new AddBasketRequest(
                    $request->name,
                    $request->maxCapacity
                )
            );

            $json = $this->jsonBasketPresenter->presentBasketFull($basketResponse->basket());

            return $this->successResponseWithMeta($json);

        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="returns success message"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="returns error"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     required=true,
     *     description="basket id from GET /baskets"
     * )
     * @SWG\Tag(name="baskets")
     */
    public function removeBasket($id)
    {
        try {
            $this->removeBasketAction->execute(
                new RemoveBasketRequest($id)
            );

            return $this->emptyResponse();

        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="returns updated basket"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="returns error"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     required=true,
     *     description="basket id from GET /baskets"
     * )
     * @SWG\Parameter(
     *     name="body",
     *     in="body",
     *     description="New basket name",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="name",
     *             type="string",
     *             example="Basket #4"
     *         ),
     *      )
     *   ),
     * @SWG\Tag(name="baskets")
     */
    public function renameBasket(Request $request, string $id): JsonResponse
    {
        try {
            $request = json_decode($request->getContent());
            $basketResponse = $this->renameBasketAction->execute(
                new RenameBasketRequest(
                    $id,
                    $request->name
                )
            );

            $json = $this->jsonBasketPresenter->presentBasketShort($basketResponse->basket());

            return $this->successResponseWithMeta($json);

        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
