<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Serializer\SerializerInterface;

abstract class Controller
{
    /**
     * @var MessageBus
     */
    private $queryBus;

    /**
     * @var MessageBus
     */
    private $commandBus;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(MessageBus $queryBus, MessageBus $commandBus, SerializerInterface $serializer)
    {
        $this->queryBus   = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    /**
     * @param mixed $query
     * @return mixed
     */
    protected function handleQuery($query)
    {
        return $this->handleMessage($this->queryBus, $query);
    }

    /**
     * @param mixed $command
     * @return object
     */
    protected function handleCommand($command)
    {
        return $this->handleMessage($this->commandBus, $command);
    }

    /**
     * @param MessageBus $bus
     * @param mixed      $message
     *
     * @return mixed
     */
    private function handleMessage(MessageBus $bus, $message)
    {
        $envelope = $bus->dispatch($message);

        /** @var HandledStamp $handleStamp */
        $handleStamp = $envelope->last(HandledStamp::class);

        return $handleStamp->getResult();
    }

    protected function serialize($any, string $format = 'json'): array
    {
        $serialized = $this->serializer->serialize($any, $format);

        return \json_decode($serialized, true);
    }
}
