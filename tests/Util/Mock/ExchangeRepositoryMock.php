<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\Exchange\ExchangeRepository;

/**
 * @method ExchangeRepository reveal
 */
final class ExchangeRepositoryMock extends Mock
{
    public function shouldAll(array $expected): self
    {
        $this->prophecy()
            ->all()
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }
}