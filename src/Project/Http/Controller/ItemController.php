<?php


namespace App\Project\Http\Controller;


use App\Project\App\UseCases\Basket\AddItems\{
    AddItemsAction,
    AddItemsRequest};
use App\Project\App\UseCases\Basket\RemoveItem\RemoveItemAction;
use App\Project\App\UseCases\Basket\RemoveItem\RemoveItemRequest;
use App\Project\Http\{
    Controller\Traits\JsonResponseTrait,
    Presenter\Basket\JsonBasketPresenter};
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Request};
use DomainException;
use Swagger\Annotations as SWG;
use App\Project\Domain\Basket\Entity\Item\ItemType;

class ItemController
{
    use JsonResponseTrait;

    private $addItemsAction;
    private $jsonBasketPresenter;
    private $removeItemAction;

    public function __construct(
        AddItemsAction $addItemsAction,
        RemoveItemAction $removeItemAction,
        JsonBasketPresenter $jsonBasketPresenter
    ) {
        $this->addItemsAction = $addItemsAction;
        $this->jsonBasketPresenter = $jsonBasketPresenter;
        $this->removeItemAction = $removeItemAction;
    }

    /**
     * @param Request $request
     * @param string $basketId
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="returns updated basket"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returns error"
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
     *     description="Type and weight of items to add",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="items",
     *             type="array",
     *             @SWG\Items(
     *                 type="object",
     *                 @SWG\Property(
     *                     property="itemType",
     *                     type="string",
     *                     enum=ItemType::ALLOWED_TYPES,
     *                     example="apple"
     *                 ),
     *                 @SWG\Property(
     *                     property="weight",
     *                     type="integer",
     *                     example=17
     *                 )
     *             )
     *         )
     *      )
     *   ),
     * @SWG\Tag(name="items")
     */
    public function addItems(Request $request, string $basketId)
    {
        try {
            $request = json_decode($request->getContent(), false);
//            dump($request);
//            die;
            $itemResponse = $this->addItemsAction->execute(
                new AddItemsRequest(
                    $basketId,
                    $request->items
                )
            );

            $json = $this->jsonBasketPresenter->presentBasketFull($itemResponse->basket());

            return $this->successResponseWithMeta($json);

        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param string $basketId
     * @return JsonResponse
     * @SWG\Response(
     *     response=200,
     *     description="returns updated basket"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returns error"
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
     *     description="Type of item to remove",
     *     required=true,
     *     @SWG\Schema(
     *         type="object",
     *         @SWG\Property(
     *             property="itemType",
     *             type="string",
     *             enum=ItemType::ALLOWED_TYPES,
     *             example="apple"
     *         ),
     *      )
     *   ),
     * @SWG\Tag(name="items")
     */
    public function removeItem(Request $request, string $basketId)
    {
        try {
            $request = json_decode($request->getContent(), false);
            $itemResponse = $this->removeItemAction->execute(
                new RemoveItemRequest($basketId, $request->itemType)
            );

            $json = $this->jsonBasketPresenter->presentBasketFull($itemResponse->basket());

            return $this->successResponseWithMeta($json);

        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
