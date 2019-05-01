<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Infrastructure\Security\UserCredentials;
use Core\Ui\Http\Exception\BadRequest;
use Core\Ui\Http\Exception\UserNotLogged;
use Core\Ui\JsonSchema\JsonSchemaValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Security\Core\Security;
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

    /**
     * @var Security
     */
    private $security;

    /**
     * @var JsonSchemaValidator
     */
    private $jsonSchemaValidator;

    public function __construct(
        MessageBus $queryBus,
        MessageBus $commandBus,
        SerializerInterface $serializer,
        Security $security,
        JsonSchemaValidator $jsonSchemaValidator
    ) {
        $this->queryBus            = $queryBus;
        $this->commandBus          = $commandBus;
        $this->serializer          = $serializer;
        $this->security            = $security;
        $this->jsonSchemaValidator = $jsonSchemaValidator;
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

    /**
     * @param        $any
     * @param string $format
     * @return array
     */
    protected function serialize($any, string $format = 'json'): array
    {
        $serialized = $this->serializer->serialize($any, $format);

        return json_decode($serialized, true);
    }

    /**
     * @param string  $type
     * @param Request $request
     *
     * @throws BadRequest
     */
    protected function validate(string $type, Request $request): void
    {
        $this->jsonSchemaValidator->validate($type, $request->getContent());
    }

    /**
     * @return string
     * @throws UserNotLogged
     */
    protected function currentUserId(): string
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserCredentials) {
            throw new UserNotLogged();
        }

        return $user->getId();
    }
}
