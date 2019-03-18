<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

class SaveCredentials
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $exchangeId;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $userId;

    /**
     * CreateCredentials constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $exchangeId
     * @param string $key
     * @param string $secret
     * @param string $userId
     */
    public function __construct(
        string $id,
        string $name,
        string $exchangeId,
        string $key,
        string $secret,
        string $userId
    ) {
        $this->id         = $id;
        $this->name       = $name;
        $this->exchangeId = $exchangeId;
        $this->key        = $key;
        $this->secret     = $secret;
        $this->userId     = $userId;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function exchangeId(): string
    {
        return $this->exchangeId;
    }

    /**
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function secret(): string
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function userId(): string
    {
        return $this->userId;
    }
}
