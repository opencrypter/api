<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventSubscriber\Symfony;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'setResponse',
        ];
    }

    public function setResponse(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $body = ['message' => $exception->getMessage()];
        $code = $exception->getCode() > 0 ? $exception->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        $response = new JsonResponse($body, $code);

        $event->setResponse($response);
    }
}
