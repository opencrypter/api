<?php
declare(strict_types=1);

namespace Core\Application\Exchange;

use Core\Domain\Exchange\Exchange;
use Core\Domain\Exchange\ExchangeRepository;

class GetAllAvailableExchangesHandler
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
     * GetAllAvailableExchangesHandler constructor.
     *
     * @param ExchangeRepository   $repository
     * @param ExchangeDtoAssembler $dtoAssembler
     */
    public function __construct(ExchangeRepository $repository, ExchangeDtoAssembler $dtoAssembler)
    {
        $this->repository = $repository;
        $this->dtoAssembler = $dtoAssembler;
    }

    public function __invoke(GetAllAvailableExchanges $query): array
    {
        $exchanges = $this->repository->all();

        return array_map(function (Exchange $exchange) {
            return $this->dtoAssembler->writeDto($exchange);
        }, $exchanges);
    }
}
