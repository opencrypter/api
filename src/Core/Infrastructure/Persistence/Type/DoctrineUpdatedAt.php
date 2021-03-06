<?php
declare(strict_types=1);

namespace Core\Infrastructure\Persistence\Type;

use Core\Domain\DateTime;
use Core\Domain\UpdatedAt;
use Core\Infrastructure\Persistence\Type\Scalar\DoctrineDateTime;

final class DoctrineUpdatedAt extends DoctrineDateTime
{
    private const NAME = 'updated_at';

    protected function name(): string
    {
        return self::NAME;
    }

    /**
     * Creates a new instance of a datetime implementation.
     *
     * @param \DateTimeImmutable $value
     * @return DateTime
     */
    protected function newInstance(\DateTimeImmutable $value): DateTime
    {
        return new UpdatedAt($value);
    }
}
