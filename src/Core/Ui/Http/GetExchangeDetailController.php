<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Exchange\GetExchangeDetail;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetExchangeDetailController extends Controller
{
    public function __invoke(string $exchangeId): JsonResponse
    {
        $exchange = $this->handleQuery(new GetExchangeDetail($exchangeId));

        return new JsonResponse($this->serialize($exchange));
    }
}
