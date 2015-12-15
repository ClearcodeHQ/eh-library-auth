<?php


namespace Clearcode\EHLibraryAuth\Application\UseCase;


use Clearcode\EHLibraryAuth\Model\UserRepository;

class GetUser
{
    /** @var UserRepository */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get($email)
    {
        return $this->repository->get($email);
    }
}
