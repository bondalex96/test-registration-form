<?php

namespace App\Tests\Domain\Specification\User;

use App\Domain\Entity\User\User;
use App\Domain\Repository\User\UserRepository;
use App\Domain\Specification\User\UniqueEmailSpecification;
use PHPUnit\Framework\TestCase;

class UniqueEmailSpecificationTest extends TestCase
{
    public function testSatisfied()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('findByEmail')->willReturn(null);
        $specification = new UniqueEmailSpecification($repository);
        $this->assertTrue($specification->isSatisfiedBy('some@email.com'));
    }

    public function testNotSatisfied()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('findByEmail')->willReturn($this->createMock(User::class));
        $specification = new UniqueEmailSpecification($repository);
        $this->assertFalse($specification->isSatisfiedBy('some@email.com'));
    }
}
