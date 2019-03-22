<?php
declare(strict_types=1);

namespace Core\Application\Credentials;

class CredentialsDto
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
    private $key;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $exchangeId;

    /**
     * CredentialsDto constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $exchangeId
     * @param string $key
     * @param string $secret
     */
    public function __construct(string $id, string $name, string $exchangeId, string $key, string $secret)
    {
        $this->id         = $id;
        $this->name       = $name;
        $this->exchangeId = $exchangeId;
        $this->key        = $key;
        $this->secret     = $secret;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getExchangeId(): string
    {
        return $this->exchangeId;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
}
