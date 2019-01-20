<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Exchange\GetExchangeDetail;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GetExchangeDetailController extends Controller
{
    public function __invoke(string $exchangeId): JsonResponse
    {
        return new JsonResponse(
            $this->serialize($this->queryBus()->handle(new GetExchangeDetail($exchangeId)))
        );
    }
}
