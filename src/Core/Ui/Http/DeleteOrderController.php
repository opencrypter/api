<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Order\DeleteOrder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteOrderController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception\UserNotLogged
     */
    public function __invoke(string $id): JsonResponse
    {
        $this->handleCommand(new DeleteOrder($id, $this->currentUserId()));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
