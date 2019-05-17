<?php
declare(strict_types=1);

namespace Tests\Util\Mock;

use Core\Application\Ticker\TickerApi;
use Core\Application\Ticker\TickerDto;

/**
 * @method TickerApi reveal
 */
class TickerApiMock extends Mock
{
    /**
     * @param TickerDto[] $expected
     * @return TickerApiMock
     */
    public function shouldFindAllTickers(array $expected): self
    {
        $this
            ->prophecy()
            ->allTickers()
            ->willReturn($expected)
            ->shouldBeCalled();

        return $this;
    }
}
