<?php

namespace App\Tests\Persistence\Repository\InMemory;

use App\Domain\Entity\User\User;
use App\Domain\Repository\NotFoundException;
use App\Persistence\Repository\InMemory\UserRepository;
use App\Test\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    private $repository;

    private $builder;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $builder = new UserBuilder();
        $firstUser = $builder->withId('1')->withEmail($email = 'someemail@gmail.com')->build();
        $secondUser = $builder->withId('2')->build();

        $this->builder = $builder;
        $this->repository = new UserRepository([$firstUser, $secondUser]);
        parent::__construct($name, $data, $dataName);
    }

    public function testSave()
    {
        $id = $this->repository->nextId();
        $user = $this
            ->builder
            ->withId($id)
            ->build();

        $this->repository->save($user);
        $persistedUser = $this->repository->getById($id);
        $this->assertEquals($user, $persistedUser);
        $this->assertEquals($user->getId(), $persistedUser->getId());
    }

    public function testFindByEmail()
    {
        $user = $this->repository->findByEmail($email = 'someemail@gmail.com');
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->getEmail(), $email);

        $user = $this->repository->findByEmail('somail@gmail.com');
        $this->assertNull($user);
    }

    public function testGetById()
    {
        $user = $this->repository->getById($id = '1');
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->getId(), $id);

        $this->expectException(NotFoundException::class);
        $this->repository->getById('dsd');
    }

    public function testNextId()
    {
        $this->assertNotEquals($this->repository->nextId(), $this->repository->nextId());
    }
}
