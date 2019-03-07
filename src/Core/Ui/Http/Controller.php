<?php
declare(strict_types=1);

namespace Core\Ui\Http;

use Core\Infrastructure\Security\UserCredentials;
use Core\Ui\Http\Exception\BadRequest;
use Core\Ui\Http\Exception\UserNotLogged;
use JsonSchema\Validator;
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
     * Controller constructor.
     *
     * @param MessageBus          $queryBus
     * @param MessageBus          $commandBus
     * @param SerializerInterface $serializer
     * @param Security            $security
     */
    public function __construct(
        MessageBus $queryBus,
        MessageBus $commandBus,
        SerializerInterface $serializer,
        Security $security
    ) {
        $this->queryBus   = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->security   = $security;
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

        return \json_decode($serialized, true);
    }

    /**
     * @param Request $request
     * @param string  $model
     * @throws BadRequest
     */
    protected function validate(Request $request, string $model): void
    {
        $validator = new Validator();

        $body       = \json_decode($request->getContent());
        $jsonSchema = __DIR__ . "/json-schema/{$model}.json";

        $validator->validate($body, (object) ['$ref' => "file://{$jsonSchema}"]);

        if (!$validator->isValid()) {
            throw BadRequest::createWithErrors($validator->getErrors());
        }
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
