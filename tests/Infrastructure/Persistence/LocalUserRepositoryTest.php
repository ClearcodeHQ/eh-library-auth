<?php

namespace tests\Clearcode\EHLibrary\Infrastructure\Persistence;

use Clearcode\EHLibraryAuth\Infrastructure\Persistence\LocalUserRepository;
use Clearcode\EHLibraryAuth\Model\User;

class LocalUserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LocalUserRepository */
    private $repository;

    /** @test */
    public function it_can_store_a_user()
    {
        $user = new User('p.baranski@example.com', ['reader']);

        $this->repository->add($user);

        $this->assertEquals($user, $this->repository->get($user->email()));
    }


    /** {@inheritdoc} */
    protected function setUp()
    {
        $this->repository = new LocalUserRepository();
        $this->repository->clear();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->repository = null;
    }
}
