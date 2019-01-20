<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\Exchange\Exchange;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\ExchangeRepository;

/**
 * @method ExchangeRepository reveal
 */
final class ExchangeRepositoryMock extends Mock
{
    public function shouldFindExchangeOfId(ExchangeId $exchangeId, ?Exchange $expected): self
    {
        $this->prophecy()
            ->exchangeOfId($exchangeId)
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldFindAll(array $expected): self
    {
        $this->prophecy()
            ->all()
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }
}
