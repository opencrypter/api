<?php
declare(strict_types=1);

namespace Core\Domain\Credentials;

use Core\Domain\AggregateRoot;
use Core\Domain\CreatedAt;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Name;
use Core\Domain\UpdatedAt;
use Core\Domain\User\UserId;

class Credentials extends AggregateRoot
{
    /**
     * @var CredentialsId
     */
    private $id;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var ExchangeId
     */
    private $exchangeId;

    /**
     * @var Key
     */
    private $key;

    /**
     * @var Secret
     */
    private $secret;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var UpdatedAt
     */
    private $updatedAt;

    /**
     * Credentials constructor.
     *
     * @param CredentialsId $id
     * @param Name          $name
     * @param ExchangeId    $exchangeId
     * @param Key           $key
     * @param Secret        $secret
     * @param UserId        $userId
     */
    public function __construct(
        CredentialsId $id,
        Name $name,
        ExchangeId $exchangeId,
        Key $key,
        Secret $secret,
        UserId $userId
    ) {
        $this->id         = $id;
        $this->name       = $name;
        $this->exchangeId = $exchangeId;
        $this->key        = $key;
        $this->secret     = $secret;
        $this->userId     = $userId;
        $this->createdAt  = CreatedAt::now();

        $this->record(CredentialsCreated::create($this));
    }

    /**
     * @return CredentialsId
     */
    public function id(): CredentialsId
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @return ExchangeId
     */
    public function exchangeId(): ExchangeId
    {
        return $this->exchangeId;
    }

    /**
     * @return Key
     */
    public function key(): Key
    {
        return $this->key;
    }

    /**
     * @return Secret
     */
    public function secret(): Secret
    {
        return $this->secret;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @param Name       $name
     * @param ExchangeId $exchangeId
     * @param Key        $key
     * @param Secret     $secret
     *
     * @return Credentials
     */
    public function update(Name $name, ExchangeId $exchangeId, Key $key, Secret $secret): self
    {
        $this->name       = $name;
        $this->exchangeId = $exchangeId;
        $this->key        = $key;
        $this->secret     = $secret;

        return $this;
    }
}
