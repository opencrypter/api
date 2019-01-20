<?php
declare(strict_types=1);

namespace Core\Application\Exchange;

use Core\Domain\Exchange\ExchangeId;
use Core\Domain\Exchange\ExchangeNotFound;
use Core\Domain\Exchange\ExchangeRepository;

class GetExchangeDetailHandler
{
    /**
     * @var ExchangeRepository
     */
    private $repository;

    /**
     * @var ExchangeDtoAssembler
     */
    private $dtoAssembler;

    /**
     * GetExchangeDetailHandler constructor.
     *
     * @param ExchangeRepository   $repository
     * @param ExchangeDtoAssembler $dtoAssembler
     */
    public function __construct(ExchangeRepository $repository, ExchangeDtoAssembler $dtoAssembler)
    {
        $this->repository = $repository;
        $this->dtoAssembler = $dtoAssembler;
    }

    /**
     * @param GetExchangeDetail $query
     * @return ExchangeDto
     * @throws ExchangeNotFound
     */
    public function handle(GetExchangeDetail $query): ExchangeDto
    {
        $exchangeId = new ExchangeId($query->exchangeId());

        $exchange = $this->repository->exchangeOfId($exchangeId);
        if ($exchange === null) {
            throw new ExchangeNotFound($exchangeId);
        }

        return $this->dtoAssembler->writeDto($exchange);
    }
}
