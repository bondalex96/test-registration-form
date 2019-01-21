<?php

namespace App\Tests\User;

use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    public function testSuccessRegistration()
    {
        $user = User::register(
            $id = 1,
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'some-email@gmail.com',
            $password = 'pa23pa2'
        );

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($nick, $user->getNickname()->getNickname());
        $this->assertEquals($firstName, $user->getName()->getFirstName());
        $this->assertEquals($lastName, $user->getName()->getLastName());
        $this->assertEquals($email, $user->getEmail());
    }

    public function testRegistrationWithInvalidEmail()
    {
        $this->expectException(new \InvalidArgumentException('Invalid email!'));
        User::register(
            $id = 1,
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'some-email@gmail.com',
            $password = 'pa23pa2'
        );
    }

    public function testRegistrationWithEmptyEmail()
    {
        $this->expectException(new \InvalidArgumentException('Email can\'t be empty!'));
        User::register(
            $id = 1,
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'some-email@gmail.com',
            $password = 'pa23pa2'
        );
    }

    public function testRegistrationWithShortPassword()
    {
        $this->expectException(new \InvalidArgumentException('Password shouldn\'t contain less than 5 characters'));
        User::register(
            $id = 1,
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'some-email@gmail.com',
            $password = 'pa2'
        );
    }
}
