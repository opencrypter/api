<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Credentials\GetAllCredentials;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetAllCredentialsController extends Controller
{
    /**
     * @return JsonResponse
     * @throws Exception\UserNotLogged
     */
    public function __invoke(): JsonResponse
    {
        $exchanges = $this->handleQuery(new GetAllCredentials($this->currentUserId()));

        return new JsonResponse($this->serialize($exchanges));
    }
}
