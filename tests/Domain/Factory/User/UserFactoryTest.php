<?php

namespace App\Tests\Domain\Factory\User;

use App\Domain\Entity\User\User;
use App\Domain\Factory\User\UserFactory;
use App\Domain\Repository\User\UserRepository;
use App\Domain\Specification\User\UniqueEmailSpecification;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    public function testSuccess()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('nextId')->willReturn($userId = 1);

        $specification = $this->createMock(UniqueEmailSpecification::class);
        $specification->method('isSatisfiedBy')->willReturn(true);

        $userFactory = new UserFactory($specification, $repository);

        $user = $userFactory->register($nick = 'nick96', $firstName = 'имя', $lastName = 'фамилия', $email = 'some-email@gmail.com', $password = 'pa23pa2');
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userId, $user->getId());
    }

    public function testWithExistingEmail()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('nextId')->willReturn($userId = 1);

        $specification = $this->createMock(UniqueEmailSpecification::class);
        $specification->method('isSatisfiedBy')->willReturn(false);

        $userFactory = new UserFactory($specification, $repository);

        $email = 'some-email@gmail.com';

        $this->expectExceptionObject(new \DomainException('User with email ' . $email . ' already exists!'));
        $userFactory->register($nick = 'nick96', $firstName = 'имя', $lastName = 'фамилия', $email , $password = 'pa23pa2');
    }
}
