<?php

namespace Tests\Util\Context;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Element\DocumentElement;
use Behatch\Context\RestContext;
use Behatch\HttpCall\Request;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Faker\Generator;

class FeatureContext extends RestContext
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var string
     */
    private $currentAuthorizationToken;

    public function __construct(EntityManager $manager, Request $request)
    {
        $this->manager = $manager;
        parent::__construct($request);
    }

    /**
     * @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function beforeScenario(BeforeScenarioScope $scope): void
    {
        (new ORMPurger($this->manager))->purge();
    }

    /**
     * @return Generator
     */
    public function faker(): Generator
    {
        return Factory::create();
    }

    public function setAuthorizationToken(?string $token): void
    {
        $this->currentAuthorizationToken = $token;
    }

    /**
     * Sends a HTTP request
     */
    public function iSendARequestTo($method, $url, PyStringNode $body = null, $files = []): DocumentElement
    {
        $this->iAddHeaderEqualTo('Content-Type', 'application/json');

        if ($this->currentAuthorizationToken !== null) {
            $this->iAddHeaderEqualTo('Authorization', 'Bearer ' . $this->currentAuthorizationToken);
        }

        return parent::iSendARequestTo($method, $url, $body, $files);
    }

    /**
     * @param string $method
     * @param string $path
     * @param array  $body
     * @return array|null
     */
    public function sendAJsonRequest(string $method, string $path, array $body = []): ?array
    {
        $body = empty($body) ? null : new PyStringNode([\json_encode($body)], 1);

        $response = $this->iSendARequestTo($method, $path, $body);

        return \json_decode($response->getContent(), true);
    }
}
