<?php

namespace App\Tests\Domain\Entity\User;

use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserName;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSuccessCreation()
    {
        $user = new User(
            $id = '1',
            $nickname = new NickName($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'some-email@gmail.com'
        );

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($nick, $user->getNickname()->getNickname());
        $this->assertEquals($firstName, $user->getName()->getFirstName());
        $this->assertEquals($lastName, $user->getName()->getLastName());
        $this->assertEquals($email, $user->getEmail());
        $this->assertNull($user->getPassword());
    }

    public function testCreationWithInvalidEmail()
    {
        $this->expectExceptionObject(new \DomainException('Невалидный электронный адрес!'));
        new User(
            $id = '1',
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'soom'
        );
    }

    public function testRegistrationWithEmptyEmail()
    {
        $this->expectExceptionObject(new \DomainException('Электронный адрес обязателен для ввода!'));
        new User(
            $id = '1',
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = ''
        );
    }

    public function setPassword()
    {
        $user = new User(
            $id = '1',
            $nickname = new Nickname($nick = 'nick96'),
            new UserName($firstName = 'имя', $lastName = 'фамилия'),
            $email = 'soom'
        );

        $user->setPassword($password = '12345');
        $this->assertEquals($user->getPassword(), $password);

        $this->expectExceptionObject(new \DomainException('У пользователя уже установлен пароль!'));
        $this->setPassword('1234567');
    }
}
