<?php


namespace Clearcode\EHLibraryAuth\Application\UseCase;

use Clearcode\EHLibraryAuth\Model\InvalidSignature;
use Clearcode\EHLibraryAuth\Model\UnrecognizedToken;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer;

class Authenticate
{
    /** @var Parser */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function authenticate($token, Signer $signer, $key)
    {
        try {
            $token = $this->parser->parse($token);
        } catch (\InvalidArgumentException $e) {
            throw new UnrecognizedToken();
        }

        if (!$token->verify($signer, $key)) {
            throw new InvalidSignature();
        }
    }
}
