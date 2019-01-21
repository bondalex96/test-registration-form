<?php

namespace App\Domain\Services;


interface PasswordEncryptor
{
    public function encrypt(string $password): string;
}