<?php
declare(strict_types=1);

namespace Tests\Util\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Core\Domain\Order\OrderId;
use Core\Domain\Order\OrderRepository;
use PHPUnit\Framework\Assert;

class OrderContext implements Context
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * @var FeatureContext
     */
    private $context;

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
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function beforeScenario(BeforeScenarioScope $scope): void
    {
        $this->context = $scope->getEnvironment()->getContext(FeatureContext::class);
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

    /**
     * @Given the order with id :id and the next steps:
     *
     * @param string    $id
     * @param TableNode $stepTableNode
     */
    public function createOrder(string $id, TableNode $stepTableNode): void
    {
        $response = $this->context->sendAJsonRequest('PUT', "/v1/orders/{$id}", [
            'steps' => $stepTableNode->getHash()
        ]);

        Assert::assertNotContains('message', $response);
    }
}
