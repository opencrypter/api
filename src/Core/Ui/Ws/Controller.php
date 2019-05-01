<?php
declare(strict_types=1);

namespace Core\Ui\Ws;

use Core\Ui\Http\Exception\BadRequest;
use Core\Ui\JsonSchema\JsonSchemaValidator;
use Exception;
use Predis\Async\Client;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;
use Redis;
use SplObjectStorage;

class Controller implements HttpServerInterface
{
    private const VALID_SUBSCRIPTIONS = [
        'OrderCreated'
    ];

    /**
     * @var SplObjectStorage[]
     */
    private $subscriptions;

    /**
     * @var Client|Redis
     */
    private $client;

    /**
     * @var JsonSchemaValidator
     */
    private $jsonSchemaValidator;

    public function __construct(Client $wsRedisClient, JsonSchemaValidator $jsonSchemaValidator)
    {
        $this->subscriptions       = [];
        $this->client              = $wsRedisClient;
        $this->jsonSchemaValidator = $jsonSchemaValidator;

        $this->client->connect(function () {
            $this->subscribe();
        });
    }

    private function subscribe(): void
    {
        $this->client->subscribe(self::VALID_SUBSCRIPTIONS, function ($message) {
            $connections = $this->subscriptions[$message[1]] ?? new SplObjectStorage();

            foreach ($connections as $connection) {
                $connection->send($this->writeMessage(false, $message[0], $message[1], $message[2]));
            }
        });
    }

    public function client(): Client
    {
        return $this->client;
    }

    private function writeMessage(bool $error, string $type, string $channel, array $payload = []): string
    {
        return json_encode([
            'error'   => $error,
            'type'    => $type,
            'channel' => $channel,
            'payload' => $payload,
        ]);
    }

    public function onOpen(ConnectionInterface $connection, RequestInterface $request = null)
    {
        $connection->send($this->writeMessage(false, 'event', 'connection'));
    }

    public function onClose(ConnectionInterface $connection)
    {
        foreach ($this->subscriptions as $topic => $connections) {
            $connections->detach($connection);
        }
    }

    public function onError(ConnectionInterface $connection, Exception $e)
    {
        $connection->send($this->writeMessage(true, 'event', 'exception', [
            'code'    => $e->getCode(),
            'message' => json_decode($e->getMessage()) ?? $e->getMessage(),
        ]));
    }

    /**
     * @param ConnectionInterface $connection
     * @param string              $message
     *
     * @throws BadRequest
     */
    public function onMessage(ConnectionInterface $connection, $message): void
    {
        $this->jsonSchemaValidator->validate('Message', $message);
        $data = json_decode(trim($message));

        if (!in_array($data->channel, self::VALID_SUBSCRIPTIONS)) {
            throw new BadRequest("The channel '{$data->channel}' is not supported");
        }

        $this->subscriptions[$data->channel] = $this->subscriptions[$data->channel] ?? new SplObjectStorage();
        $this->subscriptions[$data->channel]->attach($connection);

        $connection->send($this->writeMessage(false, $data->type, $data->channel));
    }
}
