<?php

namespace Clearcode\EHLibraryAuth\Infrastructure\Persistence;

use Clearcode\EHLibraryAuth\Model\User;
use Clearcode\EHLibraryAuth\Model\UserRepository;
use Everzet\PersistedObjects\AccessorObjectIdentifier;
use Everzet\PersistedObjects\FileRepository;

class LocalUserRepository implements UserRepository
{
    /** @var FileRepository */
    private $file;

    public function clear()
    {
        $this->file->clear();
    }

    public function get($email)
    {
        return $this->file->findById($email);
    }

    public function add(User $user)
    {
        $this->file->save($user);
    }

    public function __construct()
    {
        $this->file = new FileRepository(__DIR__.'/../../../cache/users.db', new AccessorObjectIdentifier('email'));
    }
}
