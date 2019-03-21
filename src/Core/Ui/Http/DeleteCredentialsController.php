<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\Credentials\DeleteCredentials;
use Core\Ui\Http\Exception\UserNotLogged;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteCredentialsController extends Controller
{
    /**
     * @param string  $id
     * @return JsonResponse
     * @throws UserNotLogged
     */
    public function __invoke(string $id)
    {
        $this->handleCommand(new DeleteCredentials($id, $this->currentUserId()));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
