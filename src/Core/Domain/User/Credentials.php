<?php
declare(strict_types=1);

namespace Core\Domain\User;

interface Credentials
{
    public function email(): string;
}
