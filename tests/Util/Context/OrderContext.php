<?php
declare(strict_types=1);

namespace Tests\Util\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
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
     * @Given the order with id :id exists
     *
     * @param string $id
     * @throws \Exception
     */
    public function theOrderExists(string $id): void
    {
        $response = $this->context->sendAJsonRequest('GET', "/v1/orders/{$id}");

        Assert::assertNotContains('message', $response);
    }

    /**
     * @Given the order with id :id does not exist
     *
     * @param string $id
     * @throws \Exception
     */
    public function theOrderDoesNotExist(string $id): void
    {
        $response = $this->context->sendAJsonRequest('GET', "/v1/orders/{$id}");

        Assert::assertArrayHasKey('message', $response);
    }

    /**
     * @Given the order with id :id and the next steps:
     *
     * @param string    $id
     * @param TableNode $stepTableNode
     */
    public function createOrder(string $id, TableNode $stepTableNode): void
    {
        $steps = array_map(function ($stepNode) {
            $step = [
                'position'   => $stepNode['position'] !== '' ? (int)$stepNode['position'] : null,
                'type'       => $stepNode['type'] !== '' ? $stepNode['type'] : null,
                'exchangeId' => $stepNode['exchangeId'] !== '' ? $stepNode['exchangeId'] : null,
                'symbol'     => $stepNode['symbol'] !== '' ? $stepNode['symbol'] : null,
                'value'      => $stepNode['value'] !== '' ? (float) $stepNode['value'] : null,
            ];

            if (isset($stepNode['dependsOf']) && $stepNode['dependsOf'] !== '') {
                $step['dependsOf'] = $stepNode['dependsOf'];
            }

            return $step;
        }, $stepTableNode->getHash());

        $this->context->sendAJsonRequest('PUT', "/v1/orders/{$id}", [
            'steps' => $steps
        ]);
    }

    /**
     * @Given the order with id :id equals to:
     * @param string    $id
     * @param TableNode $stepTableNode
     */
    public function equalsTo(string $id, TableNode $stepTableNode): void
    {
        $response = $this->context->sendAJsonRequest('GET', "/v1/orders/{$id}");

        $expectedSteps = array_map(function ($stepNode) {
            return [
                'position'   => (int) $stepNode['position'],
                'type'       => $stepNode['type'],
                'exchangeId' => $stepNode['exchangeId'],
                'symbol'     => $stepNode['symbol'],
                'value'      => (float) $stepNode['value'],
                'dependsOf'  => $stepNode['dependsOf'] === '' ? null : (int) $stepNode['dependsOf']
            ];
        }, $stepTableNode->getHash());

        $expected = [
            'id'    => $id,
            'steps' => $expectedSteps,
        ];

        Assert::assertEquals($expected, $response);
    }
}
