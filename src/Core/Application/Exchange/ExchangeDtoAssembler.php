<?php
declare(strict_types=1);

namespace Core\Application\Exchange;

use Core\Domain\Exchange\Exchange;

class ExchangeDtoAssembler
{
    public function writeDto(Exchange $exchange): ExchangeDto
    {
        return new ExchangeDto(
            $exchange->id()->value(),
            $exchange->name()->value()
        );
    }
}
