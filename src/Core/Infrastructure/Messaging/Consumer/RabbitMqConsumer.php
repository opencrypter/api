<?php
declare(strict_types=1);

namespace Core\Infrastructure\Messaging\Consumer;

use Core\Infrastructure\Messaging\RabbitMqProducer;
use Doctrine\Common\Persistence\ManagerRegistry;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBus;

abstract class RabbitMqConsumer implements ConsumerInterface
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var MessageBus
     */
    private $commandBus;

    /**
     * @var RabbitMqProducer
     */
    private $rabbitMqProducer;

    public function __construct(
        ManagerRegistry $doctrine,
        LoggerInterface $consoleLogger,
        MessageBus $commandBus,
        RabbitMqProducer $rabbitMqProducer
    ) {
        $this->doctrine         = $doctrine;
        $this->logger           = $consoleLogger;
        $this->commandBus       = $commandBus;
        $this->rabbitMqProducer = $rabbitMqProducer;
    }

    /**
     * Executes the logic here.
     *
     * @param string $routingKey
     * @param array  $message
     */
    abstract protected function consume(string $routingKey, array $message): void;

    /**
     * Executed when any exception is thrown.
     *
     * @param \Throwable $exception
     *
     * @return bool return false if you want to requeue the message.
     */
    abstract protected function onException(\Throwable $exception): bool;

    protected function dispatchCommand($command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function publishMessageToQueue(string $routingKey, array $message): void
    {
        $this->rabbitMqProducer->publish($routingKey, $message);
    }

    /**
     * Executes the consumer.
     *
     * @param AMQPMessage $message
     * @return bool
     */
    public function execute(AMQPMessage $message): bool
    {
        $this->logger->info("message received: {$message->body}");

        $body       = json_decode($message->body, true);
        $routingKey = $message->delivery_info['routing_key'];

        try {
            $this->consume($routingKey, $body);
            $this->doctrine->getConnection()->close();
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getMessage());

            return $this->onException($exception);
        }

        $this->logger->info('message consumed successfully');

        return true;
    }
}
