<?php
declare(strict_types=1);

namespace Core\Infrastructure\Api\Binance;

use Core\Application\Ticker\TickerApi;
use Core\Application\Ticker\TickerDto;
use GuzzleHttp\Client;

class Binance implements TickerApi
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    private function get(string $path)
    {
        $url = sprintf('https://api.binance.com%s', $path);
        $response = (string) $this->client->get($url)->getBody();

        return json_decode($response);
    }

    public function allTickers(): array
    {
        $tickers = $this->get('/api/v1/ticker/24hr');
        $symbols = $this->getSymbols();

        return array_map(function ($ticker) use ($symbols) {
            return new TickerDto(
                $ticker->symbol,
                $symbols[$ticker->symbol]->baseAsset,
                $symbols[$ticker->symbol]->quoteAsset,
                (float) $ticker->lastPrice
            );
        }, $tickers);
    }

    private function getSymbols(): array
    {
        $exchangeInfo = $this->get('/api/v1/exchangeInfo');

        $symbols = [];
        foreach ($exchangeInfo->symbols as $symbol) {
            $symbols[$symbol->symbol] = $symbol;
        }

        return $symbols;
    }
}
