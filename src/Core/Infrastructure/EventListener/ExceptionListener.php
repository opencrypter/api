<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $body = ['message' => $exception->getMessage()];
        $code = $exception->getCode() > 0 ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        $response = new JsonResponse($body, $code);

        $event->setResponse($response);
    }
}
