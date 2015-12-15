<?php

namespace Clearcode\EHLibraryAuth\Application\UseCase;


use Clearcode\EHLibraryAuth\Model\User;
use Clearcode\EHLibraryAuth\Model\UserIsAlreadyRegistered;
use Clearcode\EHLibraryAuth\Model\UserRepository;

class RegisterUser
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register($email, $roles)
    {
        if ($this->repository->get($email) instanceof User) {
            throw UserIsAlreadyRegistered::withEmail($email);
        }

        $this->repository->add(new User($email, $roles));
    }
}
