<?php

namespace App\Tests\Domain\Entity\User;

use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserName;
use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    public function testSuccessRegistration()
    {
        $user = User::register(
            $id = '1',
            $nickname = new NickName($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'some-email@gmail.com',
            $password = 'pa23pa2'
        );

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($nick, $user->getNickname()->getNickname());
        $this->assertEquals($firstName, $user->getName()->getFirstName());
        $this->assertEquals($lastName, $user->getName()->getLastName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertNotNull($email, $user->getPassword());
    }

    public function testRegistrationWithInvalidEmail()
    {
        $this->expectExceptionObject(new \DomainException('Invalid email!'));
        User::register(
            $id = '1',
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'soom',
            $password = 'pa23pa2'
        );
    }

    public function testRegistrationWithEmptyEmail()
    {
        $this->expectExceptionObject(new \DomainException('Email can\'t be empty!'));
        User::register(
            $id = '1',
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = '',
            $password = 'pa23pa2'
        );
    }

    public function testRegistrationWithShortPassword()
    {
        $this->expectExceptionObject(new \DomainException('Password shouldn\'t contain less than 5 characters'));
        User::register(
            $id = '1',
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'some-email@gmail.com',
            $password = 'pa2'
        );
    }
}
