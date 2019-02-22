<?php
declare(strict_types=1);

namespace Tests\Util\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use PHPUnit\Framework\Assert;

class SecurityContext implements Context
{
    /**
     * @var FeatureContext
     */
    private $context;

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public function gatherContext(BeforeScenarioScope $scope): void
    {
        $this->context = $scope->getEnvironment()->getContext(FeatureContext::class);
    }

    /**
     * @BeforeScenario @login
     */
    public function login()
    {
        $email    = $this->context->faker()->safeEmail;
        $password = $this->context->faker()->sha256;

        $this->givenUser($email, $password);
        $this->context->setAuthorizationToken($this->authenticateUser($email, $password));
    }

    /**
     * @AfterScenario @logout
     */
    public function logout()
    {
        $this->context->setAuthorizationToken(null);
    }

    /**
     * @Given user with username :username and password :password
     *
     * @param string $email
     * @param string $password
     */
    public function givenUser(string $email, string $password): void
    {
        $response = $this->context->sendAJsonRequest('POST', 'register', [
            'email'    => $email,
            'password' => $password
        ]);

        Assert::assertEquals(['email' => $email], $response);
    }
    /**
     * @param string $email
     * @param string $password
     * @return string
     */
    public function authenticateUser(string $email, string $password): string
    {
        $response = $this->context->sendAJsonRequest('POST', 'authenticate', [
            'email'    => $email,
            'password' => $password
        ]);

        Assert::assertTrue(\array_key_exists('token', $response), 'Authentication should return a token');

        return $response['token'];
    }
}
