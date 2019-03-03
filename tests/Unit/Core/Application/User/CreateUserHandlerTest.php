<?php
declare(strict_types=1);

namespace Tests\Unit\Core\Application\User;

use Core\Application\User\CreateUser;
use Core\Application\User\CreateUserHandler;
use Core\Domain\User\InvalidEmail;
use Core\Domain\User\InvalidPassword;
use Core\Domain\User\UserRepository;
use Symfony\Bridge\PhpUnit\ClockMock;
use Tests\Unit\Core\TestCase;
use Tests\Util\Dummy\UserPasswordEncoder;
use Tests\Util\Factory\UserFactory;
use Tests\Util\Mock\UserRepositoryMock;

/**
 * Class CreateUserHandlerTest
 *
 * @package Tests\Unit\Core\Application\User
 */
class CreateUserHandlerTest extends TestCase
{
    private $repositoryMock;

    private $handler;

    protected function setUp()
    {
        $this->repositoryMock = new UserRepositoryMock($this->prophesize(UserRepository::class));

        $this->handler = new CreateUserHandler(
            $this->repositoryMock->reveal(),
            new \Core\Infrastructure\Factory\UserFactory(new UserPasswordEncoder())
        );

        ClockMock::withClockMock(true);
    }

    /**
     * @throws \Throwable
     */
    public function testHandler(): void
    {
        $password = $this->faker()->password;
        $expected = UserFactory::withPassword($password);

        $this->repositoryMock
            ->shouldFindUserOfEmail($expected->credentials()->email(), null)
            ->shouldReturnNewIdentity($expected->id())
            ->shouldSave($expected);

        $this->handler->__invoke(new CreateUser($expected->credentials()->email(), $password));
    }

    public function invalidValuesDataProvider(): array
    {
        return [
            ['invalid', $this->faker()->sha256, InvalidEmail::class],
            ['valid@email.com', 'short', InvalidPassword::class]
        ];
    }

    /**
     * @dataProvider invalidValuesDataProvider
     *
     * @param string $email
     * @param string $password
     * @param string $exception
     * @throws \Core\Application\User\DuplicatedUser
     */
    public function testExceptionWhenReceivesInvalidValues(string $email, string $password, string $exception): void
    {
        $this->expectException($exception);
        $this->handler->__invoke(new CreateUser($email, $password));
    }
}
