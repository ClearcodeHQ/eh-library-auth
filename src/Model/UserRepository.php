<?php


namespace Clearcode\EHLibraryAuth\Model;

interface UserRepository
{
    /**
     * @param $email
     * @return User
     */
    public function get($email);

    public function add(User $user);
}
