<?php

namespace Clearcode\EHLibraryAuth;

use Clearcode\EHLibraryAuth\Model\InvalidSignature;
use Clearcode\EHLibraryAuth\Model\UnrecognizedToken;
use Clearcode\EHLibraryAuth\Model\User;
use Clearcode\EHLibraryAuth\Model\UserIsAlreadyRegistered;

interface LibraryAuth
{
    /**
     * created new user with given email and roles
     *
     * @param string $email
     * @param array $roles
     * @throws UserIsAlreadyRegistered in case there is a user registered using the same email
     * @return null
     */
    public function registerUser($email, array $roles);

    /**
     * authenticates JWT, throws exceptions if token is somehow invalid
     *
     * @param string $token JWT
     * @throws UnrecognizedToken if JWT is invalid
     * @throws InvalidSignature if JWT has been tampered
     * @return null
     */
    public function authenticate($token);

    /**
     * generates JWT with given email in the claim
     *
     * @param string $email
     * @return string JWT token
     */
    public function generateToken($email);

    /**
     * Returns user that has given email or null if there is no such user
     *
     * @param string $email
     * @return User|null
     */
    public function getUser($email);
}
