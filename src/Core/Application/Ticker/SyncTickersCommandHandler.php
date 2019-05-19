<?php
declare(strict_types=1);

namespace Core\Application\Ticker;

use Core\Application\Exchange\ExchangeNotFound;
use Core\Domain\Exchange\ExchangeRepository;
use Core\Domain\Exchange\InvalidName;
use Core\Domain\Name;
use Core\Domain\Symbol;
use Core\Domain\Ticker\Base;
use Core\Domain\Ticker\Price;
use Core\Domain\Ticker\Quote;
use Core\Domain\Ticker\Ticker;
use Core\Domain\Ticker\TickerRepository;

class SyncTickersCommandHandler
{
    /**
     * @var TickerApiFactory
     */
    private $apiFactory;

    /**
     * @var TickerRepository
     */
    private $tickerRepository;

    /**
     * @var ExchangeRepository
     */
    private $exchangeRepository;

    public function __construct(
        TickerApiFactory $apiFactory,
        TickerRepository $tickerRepository,
        ExchangeRepository $exchangeRepository
    ) {
        $this->apiFactory         = $apiFactory;
        $this->tickerRepository   = $tickerRepository;
        $this->exchangeRepository = $exchangeRepository;
    }

    /**
     * @param SyncTickers $command
     *
     * @throws TickerApiNotFound
     * @throws InvalidName
     * @throws ExchangeNotFound
     */
    public function __invoke(SyncTickers $command): void
    {
        $name = new Name($command->exchangeName());

        $api = $this->apiFactory->create($name);

        $exchange = $this->exchangeRepository->exchangeOfName($name);
        if ($exchange === null) {
            throw ExchangeNotFound::createWithName($name);
        }

        foreach ($api->allTickers() as $externalTicker) {
            $symbol = new Symbol($externalTicker->symbol());
            $price  = new Price($externalTicker->price());
            $ticker = $this->tickerRepository->tickerOfSymbolAndExchangeId($symbol, $exchange->id());

            if ($ticker === null) {
                $this->tickerRepository->save(
                    new Ticker(
                        $this->tickerRepository->newId(),
                        $symbol,
                        new Base($externalTicker->base()),
                        new Quote($externalTicker->quote()),
                        $exchange->id(),
                        $price
                    )
                );
                continue;
            }

            if ($ticker->price()->equals($price)) {
                continue;
            }

            $ticker->updatePrice($price);
            $this->tickerRepository->save($ticker);
        }
    }
}
