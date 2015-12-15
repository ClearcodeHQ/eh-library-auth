<?php

namespace Clearcode\EHLibraryAuth;

interface LibraryAuth
{
    public function registerUser($email, array $roles);

    public function authenticate($token);

    public function generateToken($email);
}
