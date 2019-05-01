<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Order\SaveOrder;
use Core\Ui\Http\Exception\BadRequest;
use Core\Ui\Http\Exception\UserNotLogged;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutOrderController extends Controller
{
    /**
     * @param Request $request
     * @param string  $id
     * @return JsonResponse
     * @throws UserNotLogged
     * @throws BadRequest
     */
    public function __invoke(Request $request, string $id)
    {
        $this->validate('Order', $request);

        $body = json_decode($request->getContent(), true);

        $this->handleCommand(new SaveOrder($id, $this->currentUserId(), $body['steps']));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
