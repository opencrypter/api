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
     * @login
     *
     * @param BeforeScenarioScope $scope
     */
    public function login(BeforeScenarioScope $scope)
    {
        $this->context = $scope->getEnvironment()->getContext(FeatureContext::class);

        $email    = $this->context->faker()->safeEmail;
        $password = $this->context->faker()->sha256;

        $this->givenUser($email, $password);
        $token = $this->authenticateUser($email, $password);

        $this->context->addHeader('Authorization', "Bearer $token");
    }

    /**
     * @AfterScenario
     * @logout
     */
    public function logout()
    {
        $this->context->addHeader('Authorization', '');
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
