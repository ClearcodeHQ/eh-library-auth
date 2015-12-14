<?php

namespace Clearcode\EHLibraryAuth\UseCase;


use Clearcode\EHLibraryAuth\Model\User;
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
        $this->repository->add(new User($email, $roles));
    }
}
