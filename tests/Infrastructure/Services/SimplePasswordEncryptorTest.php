<?php

namespace App\Tests\Infrastructure\Services;

use App\Infrastructure\Services\SimplePasswordEncryptor;
use PHPUnit\Framework\TestCase;

class SimplePasswordEncryptorTest extends TestCase
{
    public function test()
    {
        $encryptor = new SimplePasswordEncryptor();
        $encryptedPassword = $encryptor->encrypt($originPassword = '123');
        $this->assertNotEquals($encryptedPassword, $originPassword);
    }
}
