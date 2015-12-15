<?php


namespace Clearcode\EHLibraryAuth\Model;


class UserIsAlreadyRegistered extends \Exception
{
    public static function withEmail($email)
    {
        return new self("User with email $email already exists");
    }
}