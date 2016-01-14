<?php

namespace Clearcode\EHLibraryAuth\Model;

class User
{
    /** @var string */
    private $email;
    /** @var array */
    private $roles;

    /**
     * @param $email
     * @param $roles
     */
    public function __construct($email, $roles)
    {
        $this->email = $email;
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function roles()
    {
        return $this->roles;
    }
}
