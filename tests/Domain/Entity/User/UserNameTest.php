<?php

namespace App\Tests\Domain\Entity\User;

use App\Domain\Entity\User\UserName;
use PHPUnit\Framework\TestCase;

class UserNameTest extends TestCase
{
    public function testSuccessCreation()
    {
        $name = new UserName($firstName = 'имя', $lastName = 'фамилия');
        $this->assertEquals($firstName, $name->getFirstName());
        $this->assertEquals($lastName, $name->getLastName());
    }

    public function testCreationWithNoRussianCharOnFirstName()
    {
        $this->expectExceptionObject(new \DomainException('Имя может содержать только русские символы!'));
        new UserName($firstName = 'firstName', $lastName = 'фамилия');
    }

    public function testCreationWithEmptyFirstName()
    {
        $this->expectExceptionObject(new \DomainException('Имя обязательно для ввода!'));
        new UserName($firstName = '', $lastName = 'фамилия');
    }

    public function testCreationWithNoRussianCharOnLastName()
    {
        $this->expectExceptionObject(new \DomainException('Фамилия может содержать только русские символы!'));
        new UserName($firstName = 'имя', $lastName = 'LastName');
    }

    public function testCreationWithEmptyLastName()
    {
        $this->expectExceptionObject(new \DomainException('Фамилия обязательна для ввода!'));
        new UserName($firstName = 'имя', $lastName = '');
    }
}
