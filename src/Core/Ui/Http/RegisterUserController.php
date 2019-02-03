<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Application\User\CreateUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = \json_decode($request->getContent(), true);

        $this->handleCommand(new CreateUser(
            $user['email'],
            $user['password']
        ));

        return new JsonResponse(['email' => $user['email']], Response::HTTP_CREATED);
    }
}
