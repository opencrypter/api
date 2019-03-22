<?php
declare(strict_types=1);

namespace Tests\Util\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Core\Domain\Credentials\CredentialsId;
use Core\Domain\Credentials\CredentialsRepository;
use PHPUnit\Framework\Assert;

class CredentialsContext implements Context
{
    /**
     * @var FeatureContext
     */
    private $context;

    /**
     * @var CredentialsRepository
     */
    private $repository;

    public function __construct(CredentialsRepository $repository)
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
     * @Given the credentials with id :id do not exist
     *
     * @param string $id
     * @throws \Exception
     */
    public function theCredentialsDontExist(string $id): void
    {
        Assert::assertNull($this->repository->credentialsOfId(new CredentialsId($id)));
    }

    /**
     * @Given the next credentials:
     *
     * @param TableNode $credentialsTableNode
     */
    public function createCredentials(TableNode $credentialsTableNode): void
    {
        foreach ($credentialsTableNode as $node) {
            $id   = $node['id'] !== '' ? $node['id'] : null;
            $body = [
                'name'       => $node['name'] !== '' ? $node['name'] : null,
                'exchangeId' => $node['exchangeId'] !== '' ? $node['exchangeId'] : null,
                'key'        => $node['key'] !== '' ? $node['key'] : null,
                'secret'     => $node['secret'] !== '' ? $node['secret'] : null,
            ];

            $response = $this->context->sendAJsonRequest('PUT', "/v1/credentials/{$id}", $body);
            Assert::isEmpty($response);
        }
    }
}
