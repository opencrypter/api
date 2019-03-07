<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Order\GetOrder;
use Core\Ui\Http\Exception\UserNotLogged;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetOrderController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     * @throws UserNotLogged
     */
    public function __invoke(string $id): JsonResponse
    {
        $order = $this->handleQuery(new GetOrder($id, $this->currentUserId()));

        return new JsonResponse($this->serialize($order));
    }
}
