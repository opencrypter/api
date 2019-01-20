<?php
declare(strict_types=1);

namespace Tests\Util\Context;

use Behat\Gherkin\Node\TableNode;
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
     * @Given the following exchanges:
     *
     * @param TableNode $exchanges
     */
    public function exchangeInRepository(TableNode $exchanges): void
    {
        foreach ($exchanges->getHash() as $exchange) {
            $this->repository->save(ExchangeFactory::create(
                $exchange['id'],
                $exchange['name'],
                \json_decode($exchange['symbols'], true)
            ));
        }
    }
}
