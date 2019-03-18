<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Id;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineId;

final class DoctrineCredentialsId extends DoctrineId
{
    public const NAME = 'credentials_id';

    /**
     * Name to be used by Doctrine.
     *
     * @return string
     */
    protected function name(): string
    {
        return self::NAME;
    }

    /**
     * Returns a new Id.
     *
     * @param string $value
     * @return Id
     */
    protected function newInstance(string $value): Id
    {
        return new CredentialsId($value);
    }
}
