<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Credentials\SaveCredentials;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveCredentialsController extends Controller
{
    /**
     * @param Request $request
     * @param string  $id
     * @return JsonResponse
     * @throws Exception\BadRequest
     * @throws Exception\UserNotLogged
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $this->validate('Credentials', $request);

        $body = json_decode($request->getContent(), true);

        $this->handleCommand(new SaveCredentials(
            $id,
            $body['name'],
            $body['exchangeId'],
            $body['key'],
            $body['secret'],
            $this->currentUserId()
        ));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
