<?php


namespace Clearcode\EHLibraryAuth\Application\UseCase;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer;
use Ramsey\Uuid\Uuid;

class GenerateToken
{
    /** @var Builder  */
    private $tokenBuilder;

    public function __construct(Builder $tokenBuilder)
    {
        $this->tokenBuilder = $tokenBuilder;
    }

    public function generate($email, Signer $signer, $key)
    {
        $token = $this->tokenBuilder
            ->setId(Uuid::uuid4(), true)
            ->setIssuedAt(time())
            ->setExpiration(time() + 3600)
            ->set('email', $email)
            ->sign($signer, $key)
            ->getToken();

        return $token;
    }
}
