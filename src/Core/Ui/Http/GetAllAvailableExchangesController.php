<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Exchange\GetAllAvailableExchanges;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class GetAllAvailableExchangesController extends Controller
{
    public function run()
    {
        return new JsonResponse(
            $this->serialize($this->queryBus()->handle(new GetAllAvailableExchanges))
        );
    }
}
