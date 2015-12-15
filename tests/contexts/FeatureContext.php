<?php

namespace tests\Clearcode\EHLibraryAuth\contexts;

use Behat\Behat\Context\SnippetAcceptingContext;
use Clearcode\EHLibraryAuth\Infrastructure\Persistence\LocalUserRepository;
use Clearcode\EHLibraryAuth\LibraryAuth;
use Clearcode\EHLibraryAuth\Application;
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
