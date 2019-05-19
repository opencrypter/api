<?php
declare(strict_types=1);

namespace Core\Infrastructure\EventSubscriber\Domain;

use Core\Infrastructure\Messaging\RabbitMqProducer;

abstract class DomainEventSubscriber
{
    /**
     * @var RabbitMqProducer
     */
    private $rabbitMqProducer;

    public function __construct(RabbitMqProducer $rabbitMqProducer)
    {
        $this->rabbitMqProducer = $rabbitMqProducer;
    }

    protected function publish(string $routingKey, array $message): void
    {
        $this->rabbitMqProducer->publish($routingKey, $message);
    }
}
