<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use League\Tactician\CommandBus;
use Symfony\Component\Serializer\SerializerInterface;

abstract class Controller
{
    /**
     * @var CommandBus
     */
    private $queryBus;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(CommandBus $queryBus, CommandBus $commandBus, SerializerInterface $serializer)
    {
        $this->queryBus   = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
    }

    /**
     * @return CommandBus
     */
    protected function queryBus(): CommandBus
    {
        return $this->queryBus;
    }

    /**
     * @return CommandBus
     */
    protected function commandBus(): CommandBus
    {
        return $this->commandBus;
    }

    protected function serialize($any, string $format = 'json'): array
    {
        $serialized = $this->serializer->serialize($any, $format);

        return \json_decode($serialized, true);
    }
}
