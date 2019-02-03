<?php
declare(strict_types=1);

namespace Core\Infrastructure\Factory;

use Core\Domain\User\PlainPassword;
use Core\Domain\User\User;
use Core\Domain\User\UserId;
use Core\Domain\User\Email;
use Core\Infrastructure\Security\UserCredentials;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory implements \Core\Domain\User\UserFactory
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    /**
     * @param UserId        $userId
     * @param Email         $email
     * @param PlainPassword $plainPassword
     * @return User
     * @throws \ReflectionException
     */
    public function create(UserId $userId, Email $email, PlainPassword $plainPassword): User
    {
        $password = $this->encoder->encodePassword(
            $this->createReflectionOfUserCredentials(),
            $plainPassword->value()
        );

        $credentials = new UserCredentials($userId->value(), $email->value(), $password);

        return new User($userId, $credentials);
    }

    /**
    * @return UserCredentials
    * @throws \ReflectionException
    */
    private function createReflectionOfUserCredentials(): UserCredentials
    {
        $credentials = (new \ReflectionClass(UserCredentials::class))->newInstanceWithoutConstructor();

        return $credentials;
    }
}
