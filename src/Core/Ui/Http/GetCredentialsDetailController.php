<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Credentials\GetCredentialsDetail;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetCredentialsDetailController extends Controller
{
    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception\UserNotLogged
     */
    public function __invoke(string $id): JsonResponse
    {
        $credentials = $this->handleQuery(new GetCredentialsDetail($id, $this->currentUserId()));

        return new JsonResponse($this->serialize($credentials));
    }
}
