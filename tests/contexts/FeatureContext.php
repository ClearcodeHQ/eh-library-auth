<?php

namespace tests\Clearcode\EHLibraryAuth\contexts;

use Behat\Behat\Context\SnippetAcceptingContext;
use Clearcode\EHLibraryAuth\Infrastructure\Persistence\LocalUserRepository;
use Clearcode\EHLibraryAuth\LibraryAuth;
use Clearcode\EHLibraryAuth\Application;
use Clearcode\EHLibraryAuth\Model\InvalidSignature;
use Clearcode\EHLibraryAuth\Model\UnrecognizedToken;
use Clearcode\EHLibraryAuth\Model\User;
use Clearcode\EHLibraryAuth\Model\UserIsAlreadyRegistered;

class FeatureContext implements SnippetAcceptingContext
{
    /** @var array */
    private $projection = [];
    /** @var \Exception[] */
    private $exceptions = [];
    /** @var LibraryAuth */
    private $library;

    /** @BeforeScenario */
    public function clearDatabase()
    {
        $this->userRepository()->clear();
    }

    /** @BeforeScenario */
    public function createApplication()
    {
        $this->library = new Application();
    }

    /**
     * @When /I register a reader with email (.+)/
     * @Given /I registered a reader with email (.+)/
     */
    public function iRegisterAReaderWithEmail($email)
    {
        $this->execute(function() use($email) {
            $this->library->registerUser($email, ['reader']);
        });
    }

    /**
     * @Then /the (.+) user should be registered library user/
     */
    public function theUserShouldBeRegisteredLibraryUser($email)
    {
        \PHPUnit_Framework_Assert::assertInstanceOf(User::class, $this->userRepository()->get($email));
    }

    /**
     * @Then /I should get an exception that user already exists/
     */
    public function iShouldGetAnExceptionThatUserAlreadyExists()
    {
        \PHPUnit_Framework_Assert::assertTrue($this->expectedExceptionWasThrown(UserIsAlreadyRegistered::class));
    }

    /**
     * @Given /I generated a token for (.+)/
     */
    public function iGeneratedAToken($email)
    {
        $this->project(function() use($email) {
            return $this->library->generateToken($email);
        });
    }

    /**
     * @When I authenticate using the token
     */
    public function iAuthenticateUsingTheToken()
    {
        $this->execute(function() {
            $this->library->authenticate($this->projection);
        });
    }

    /**
     * @Then authentication is successful
     */
    public function authenticationIsSuccessful()
    {
        \PHPUnit_Framework_Assert::assertEmpty($this->exceptions);
    }

    /**
     * @When /I authenticate using the (.+) token/
     */
    public function iAuthenticateUsingCustomToken($token)
    {
        $this->execute(function() use($token) {
            $this->library->authenticate($token);
        });
    }

    /**
     * @Then unrecognized token exception should be thrown
     */
    public function unrecognizedTokenExceptionShouldBeThrown()
    {
        \PHPUnit_Framework_Assert::assertTrue($this->expectedExceptionWasThrown(UnrecognizedToken::class));
    }

    /**
     * @Then invalid signature exception is thrown
     */
    public function invalidSignatureExceptionIsThrown()
    {
        \PHPUnit_Framework_Assert::assertTrue($this->expectedExceptionWasThrown(InvalidSignature::class));
    }

    private function userRepository()
    {
        return new LocalUserRepository();
    }

    private function execute(\Closure $useCase)
    {
        try {
            $useCase();
        } catch (\Exception $e) {
            $this->exceptions[] = $e;
        }
    }

    private function project(\Closure $projection)
    {
        $this->projection = $projection();
    }

    private function expectedExceptionWasThrown($expectedExceptionClass)
    {
        return !empty(array_filter($this->exceptions, function (\Exception $exception) use ($expectedExceptionClass) {
            return $exception instanceof $expectedExceptionClass;
        }));
    }
}
