<?php
declare(strict_types=1);

namespace Tests\Util\Context;

use Tests\Util\Factory\ExchangeFactory;
use Behat\Behat\Context\Context;
use Core\Domain\Exchange\ExchangeRepository;

class ExchangeContext implements Context
{
    /**
     * @var ExchangeRepository
     */
    private $repository;

    /**
     * ExchangeContext constructor.
     *
     * @param ExchangeRepository $repository
     */
    public function __construct(ExchangeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Given /^(?P<numberOfExchanges>\d+) random exchanges in repository$/
     *
     * @param int $numberOfExchanges
     */
    public function nRandomExchangesInRepository(int $numberOfExchanges): void
    {
        for ($i = 0; $i < $numberOfExchanges; $i++) {
            $this->repository->save(ExchangeFactory::random());
        }
    }
}
