<?php

namespace Clearcode\EHLibraryAuth;


use Clearcode\EHLibraryAuth\Application\UseCase\Authenticate;
use Clearcode\EHLibraryAuth\Application\UseCase\GenerateToken;
use Clearcode\EHLibraryAuth\Application\UseCase\GetUser;
use Clearcode\EHLibraryAuth\Infrastructure\Persistence\LocalUserRepository;
use Clearcode\EHLibraryAuth\Application\UseCase\RegisterUser;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Hmac\Sha256;

final class Application implements LibraryAuth
{
    /** @var Signer */
    private $jwtSigner;
    /** @var string  */
    private $jwtKey;

    public function __construct()
    {
        $this->jwtSigner = new Sha256();
        $this->jwtKey = 'MY_JWT_KEY';
    }

    public function registerUser($email, array $roles)
    {
        (new RegisterUser(new LocalUserRepository()))->register($email, $roles);
    }

    public function authenticate($token)
    {
        (new Authenticate(new Parser()))->authenticate($token, $this->jwtSigner, $this->jwtKey);
    }

    public function generateToken($email)
    {
        return (new GenerateToken(new Builder()))->generate($email, $this->jwtSigner, $this->jwtKey);
    }

    public function getUser($email)
    {
        return (new GetUser(new LocalUserRepository()))->get($email);
    }
}
