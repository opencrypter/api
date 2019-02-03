<?php

namespace Tests\Util\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behatch\Context\RestContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Faker\Generator;

class FeatureContext implements Context
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var RestContext
     */
    private $rest;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function beforeScenario(BeforeScenarioScope $scope): void
    {
        $this->rest = $scope->getEnvironment()->getContext(RestContext::class);

        (new ORMPurger($this->manager))->purge();
    }

    /**
     * @return Generator
     */
    public function faker(): Generator
    {
        return Factory::create();
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function addHeader(string $key, string $value): void
    {
        $this->rest->iAddHeaderEqualTo($key, $value);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $body
     * @return array
     */
    public function sendAJsonRequest(string $method, string $path, array $body = []): array
    {
        $body = empty($body) ? null : new PyStringNode([\json_encode($body)], 1);

        $this->rest->iAddHeaderEqualTo('Content-Type', 'application/json');

        $response = $this->rest->iSendARequestTo($method, $path, $body);

        return \json_decode($response->getContent(), true);
    }
}
