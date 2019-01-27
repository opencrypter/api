<?php
declare(strict_types=1);

namespace Tests\Util\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use Tests\Util\Factory\OrderFactory;

class OrderContext implements Context
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * OrderContext constructor.
     *
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Given the following orders:
     *
     * @param TableNode $tableNode
     */
    public function ordersInRepository(TableNode $tableNode): void
    {
        foreach ($tableNode->getHash() as $order) {
            $this->repository->save(OrderFactory::create($order['id']));
        }
    }

    /**
     * @Given the order with id :id exists in the repository
     *
     * @param string $id
     * @throws \Exception
     */
    public function theOrderExists(string $id): void
    {
        if (! $this->repository->orderOfId(new OrderId($id))) {
            throw new \Exception("Order with id {$id}  not found");
        }
    }
}
