<?php

namespace App\Tests\Domain\Factory\User;

use App\Domain\Entity\User\User;
use App\Domain\Factory\User\UserFactory;
use App\Domain\Repository\User\UserRepository;
use App\Domain\Specification\User\UniqueEmailSpecification;
use App\Domain\Specification\User\UniqueNicknameSpecification;
use App\Infrastructure\Services\SimplePasswordEncryptor;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    public function testSuccess()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('nextId')->willReturn($userId = 1);

        $uniqueEmailSpecification = $this->createMock(UniqueEmailSpecification::class);
        $uniqueEmailSpecification->method('isSatisfiedBy')->willReturn(true);

        $uniqueNickSpecification = $this->createMock(UniqueNicknameSpecification::class);
        $uniqueNickSpecification->method('isSatisfiedBy')->willReturn(true);

        $userFactory = new UserFactory($uniqueEmailSpecification, $uniqueNickSpecification, $repository, new SimplePasswordEncryptor());

        $user = $userFactory->register($nick = 'nick96', $firstName = 'имя', $lastName = 'фамилия', $email = 'some-email@gmail.com', $password = 'pa23pa2');
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userId, $user->getId());
    }

    public function testWithExistingEmail()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('nextId')->willReturn($userId = 1);

        $uniqueEmailSpecification = $this->createMock(UniqueEmailSpecification::class);
        $uniqueEmailSpecification->method('isSatisfiedBy')->willReturn(false);

        $uniqueNickSpecification = $this->createMock(UniqueNicknameSpecification::class);
        $uniqueNickSpecification->method('isSatisfiedBy')->willReturn(true);

        $userFactory = new UserFactory($uniqueEmailSpecification, $uniqueNickSpecification, $repository, new SimplePasswordEncryptor());

        $email = 'some-email@gmail.com';

        $this->expectExceptionObject(new \DomainException('User with email ' . $email . ' already exists!'));
        $userFactory->register($nick = 'nick96', $firstName = 'имя', $lastName = 'фамилия', $email , $password = 'pa23pa2');
    }

    public function testWithExistingNick()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('nextId')->willReturn($userId = 1);

        $uniqueEmailSpecification = $this->createMock(UniqueEmailSpecification::class);
        $uniqueEmailSpecification->method('isSatisfiedBy')->willReturn(true);

        $uniqueNickSpecification = $this->createMock(UniqueNicknameSpecification::class);
        $uniqueNickSpecification->method('isSatisfiedBy')->willReturn(false);

        $userFactory = new UserFactory($uniqueEmailSpecification, $uniqueNickSpecification, $repository, new SimplePasswordEncryptor());

        $email = 'some-email@gmail.com';
        $nick = 'nick96';
        $this->expectExceptionObject(new \DomainException('User with nick ' . $nick . ' already exists!'));
        $userFactory->register($nick, $firstName = 'имя', $lastName = 'фамилия', $email , $password = 'pa23pa2');
    }

    public function testWithShortPassword()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('nextId')->willReturn($userId = 1);

        $uniqueEmailSpecification = $this->createMock(UniqueEmailSpecification::class);
        $uniqueEmailSpecification->method('isSatisfiedBy')->willReturn(true);

        $uniqueNickSpecification = $this->createMock(UniqueNicknameSpecification::class);
        $uniqueNickSpecification->method('isSatisfiedBy')->willReturn(true);

        $userFactory = new UserFactory($uniqueEmailSpecification, $uniqueNickSpecification, $repository, new SimplePasswordEncryptor());

        $this->expectExceptionObject(new \DomainException('Password shouldn\'t contain less than 5 characters'));
        $userFactory->register($nick = 'nick96', $firstName = 'имя', $lastName = 'фамилия', $email = 'some-email@gmail.com', $password = 'pa23');
    }
}
