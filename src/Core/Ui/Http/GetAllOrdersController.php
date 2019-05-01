<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Order\GetAllOrders;
use Core\Ui\Http\Exception\UserNotLogged;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetAllOrdersController extends Controller
{
    /**
     * @return JsonResponse
     * @throws UserNotLogged
     */
    public function __invoke(): JsonResponse
    {
        $orders = $this->handleQuery(new GetAllOrders($this->currentUserId()));

        return new JsonResponse($this->serialize($orders));
    }
}
