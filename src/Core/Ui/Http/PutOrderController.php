<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Order\CreateOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutOrderController extends Controller
{
    public function __invoke(Request $request, string $id)
    {
        $body = json_decode($request->getContent(), true);

        $order = $this->commandBus()->handle(new CreateOrder($id, $body['steps']));

        return new JsonResponse($this->serialize($order), Response::HTTP_CREATED);
    }
}
