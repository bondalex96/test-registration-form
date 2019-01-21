<?php

namespace App\Tests\Domain\Specification\User;

use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Repository\User\UserRepository;
use App\Domain\Specification\User\UniqueNicknameSpecification;
use PHPUnit\Framework\TestCase;

class UniqueNickSpecificationTest extends TestCase
{
    public function testSatisfied()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('findByNick')->willReturn(null);
        $specification = new UniqueNicknameSpecification($repository);
        $this->assertTrue($specification->isSatisfiedBy(new NickName('nick')));
    }

    public function testNotSatisfied()
    {
        $repository = $this->createMock(UserRepository::class);
        $repository->method('findByNick')->willReturn($this->createMock(User::class));
        $specification = new UniqueNicknameSpecification($repository);
        $this->assertFalse($specification->isSatisfiedBy(new NickName('nick1')));
    }
}
