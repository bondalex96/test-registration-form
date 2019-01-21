<?php

namespace App\Tests\Application\UseCase;

use App\Application\DTO\RegistrationDto;
use App\Application\UseCase\CheckUniqueEmail;
use App\Application\UseCase\Registration;
use App\Domain\Entity\User\User;
use App\Persistence\Repository\Doctrine\UserRepository;
use App\Test\User\UserBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckUniqueEmailTest extends KernelTestCase
{
    private $repository;
    private $interactor;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        self::bootKernel();
        $container = self::$container;

        $this->repository = $container->get(UserRepository::class);
        $this->interactor = $container->get(CheckUniqueEmail::class);

        $userBuilder = new UserBuilder();
        $firstUser = $userBuilder
            ->withId($this->repository->nextId())
            ->withEmail('some@email.com')
            ->build();

        $this->repository->removeAll();
        $this->repository->save($firstUser);

        parent::__construct($name, $data, $dataName);
    }

    public function testUnique()
    {
        $this->assertFalse($this->interactor->execute("some@email.com"));
        $this->assertTrue($this->interactor->execute("somesome@email.com"));
    }
}
