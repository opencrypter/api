<?php
declare(strict_types=1);

namespace Tests\Util\Dummy;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserPasswordEncoder implements UserPasswordEncoderInterface
{

    /**
     * Encodes the plain password.
     *
     * @param UserInterface $user          The user
     * @param string        $plainPassword The password to encode
     *
     * @return string The encoded password
     */
    public function encodePassword(UserInterface $user, $plainPassword)
    {
        return $plainPassword;
    }

    /**
     * @param UserInterface $user The user
     * @param string        $raw  A raw password
     *
     * @return bool true if the password is valid, false otherwise
     */
    public function isPasswordValid(UserInterface $user, $raw)
    {
        return true;
    }
}
