<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Order\SaveOrder;
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
     */
    public function __invoke(Request $request, string $id)
    {
        $body = json_decode($request->getContent(), true);

        $this->handleCommand(new SaveOrder($id, $this->currentUserId(), $body['steps']));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
