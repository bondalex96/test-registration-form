<?php

namespace App\Infrastructure\Services;


use App\Domain\Services\PasswordEncryptor;

class SimplePasswordEncryptor implements PasswordEncryptor
{
    public function encrypt(string $password): string
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        if ($hash) {
            return $hash;
        }
        throw new \Exception('Encryption password failed!');
    }
}