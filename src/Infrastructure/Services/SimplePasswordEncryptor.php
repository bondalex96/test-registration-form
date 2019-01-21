<?php

namespace App\Infrastructure\Services;


use App\Domain\Services\PasswordEncryptor;

class SimplePasswordEncryptor implements PasswordEncryptor
{
    public function encrypt(string $password): string
    {
       return password_hash($password, PASSWORD_BCRYPT);
    }
}