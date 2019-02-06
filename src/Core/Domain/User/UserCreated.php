<?php
declare(strict_types=1);

namespace Core\Domain\User;

use Core\Domain\CreatedAt;
use Core\Domain\Event\Event;
use Core\Domain\Event\OccurredOn;
use Core\Domain\Id;

class UserCreated implements Event
{
    /**
     * @var UserId
     */
    private $id;

    /**
     * @var Credentials
     */
    private $credentials;

    /**
     * @var CreatedAt
     */
    private $createdAt;

    /**
     * @var \Core\Domain\DateTime|OccurredOn
     */
    private $occurredOn;

    /**
     * @param User $user
     * @return UserCreated
     */
    public static function create(User $user): self
    {
        return new self($user->id(), $user->credentials(), $user->createdAt());
    }

    /**
     * UserCreated constructor.
     *
     * @param UserId      $id
     * @param Credentials $credentials
     * @param CreatedAt   $createdAt
     */
    private function __construct(UserId $id, Credentials $credentials, CreatedAt $createdAt)
    {
        $this->id          = $id;
        $this->credentials = $credentials;
        $this->createdAt   = $createdAt;
        $this->occurredOn  = OccurredOn::now();
    }

    /**
     * @return Id
     */
    public function aggregateRootId(): Id
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function payload(): array
    {
        return [
            'id'          => $this->id->value(),
            'credentials' => [
                'email'    => $this->credentials->email(),
                'password' => $this->credentials->encodedPassword(),
            ],
            'createdAt'   => $this->createdAt->format(),
        ];
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn->value();
    }
}
