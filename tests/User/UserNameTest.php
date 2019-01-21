<?php

namespace App\Tests\User;

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
        $this->expectExceptionObject(new \DomainException('First name should have only Russian characters!'));
        new UserName($firstName = 'firstName', $lastName = 'фамилия');
    }

    public function testCreationWithEmptyFirstName()
    {
        $this->expectExceptionObject(new \DomainException('First name shouldn\'t be empty!'));
        new UserName($firstName = '', $lastName = 'фамилия');
    }

    public function testCreationWithNoRussianCharOnLastName()
    {
        $this->expectExceptionObject(new \DomainException('Last name should have only Russian characters!'));
        new UserName($firstName = 'имя', $lastName = 'LastName');
    }

    public function testCreationWithEmptyLastName()
    {
        $this->expectExceptionObject(new \DomainException('Last name shouldn\'t be empty!'));
        new UserName($firstName = 'имя', $lastName = '');
    }
}
