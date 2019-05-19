<?php
declare(strict_types=1);

namespace Core\Infrastructure\Messaging;

use OldSound\RabbitMqBundle\RabbitMq\Producer;

class RabbitMqProducer
{
    /**
     * @var Producer
     */
    private $producer;

    public function __construct(Producer $queueProducer)
    {
        $this->producer = $queueProducer;
    }

    public function publish(string $routingKey, array $message): void
    {
        $this->producer->publish(json_encode($message), $routingKey);
    }
}
