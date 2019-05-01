<?php
declare(strict_types=1);

namespace Core\Infrastructure\Bus;

use Core\Infrastructure\EventSubscriber\Doctrine\AggregateRootEventSubscriber;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class DomainEventsMiddleware implements MiddlewareInterface
{
    /**
     * @var AggregateRootEventSubscriber
     */
    private $eventRecorder;

    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    public function __construct(MessageBusInterface $eventBus, AggregateRootEventSubscriber $eventRecorder)
    {
        $this->eventRecorder = $eventRecorder;
        $this->eventBus = $eventBus;
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $next = $stack->next()->handle($envelope, $stack);

        foreach ($this->eventRecorder->releaseEvents() as $event) {
            $this->eventBus->dispatch($event);
        }

        return $next;
    }
}
