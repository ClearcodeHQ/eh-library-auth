<?php

namespace Clearcode\EHLibraryAuth;

interface LibraryAuth
{
    public function registerUser($email, array $roles);
}
