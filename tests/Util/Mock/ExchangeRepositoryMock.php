<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Domain\Exchange\Exchange;
use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\ExchangeRepository;
use Core\Domain\Name;

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

    public function shouldFindExchangeOfName(Name $name, ?Exchange $expected): self
    {
        $this->prophecy()
            ->exchangeOfName($name)
            ->willReturn($expected)
            ->shouldBeCalledOnce();

        return $this;
    }

    public function shouldExist(ExchangeId $exchangeId, bool $expected): self
    {
        $this->prophecy()
            ->exists($exchangeId)
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
