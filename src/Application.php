<?php

namespace Clearcode\EHLibraryAuth;


use Clearcode\EHLibraryAuth\Infrastructure\Persistence\LocalUserRepository;
use Clearcode\EHLibraryAuth\Application\UseCase\RegisterUser;

final class Application implements LibraryAuth
{
    public function registerUser($email, array $roles)
    {
        (new RegisterUser(new LocalUserRepository()))->register($email, $roles);
    }
}
