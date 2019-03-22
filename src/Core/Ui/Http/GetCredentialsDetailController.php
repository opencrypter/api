<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Credentials\GetCredentialsDetail;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetCredentialsDetailController extends Controller
{
    public function __invoke(string $id): JsonResponse
    {
        $credentials = $this->handleQuery(new GetCredentialsDetail($id));

        return new JsonResponse($this->serialize($credentials));
    }
}
