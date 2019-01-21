<?php

namespace App\Tests\Application\UseCase;

use App\Application\UseCase\CheckUniqueNick;
use App\Persistence\Repository\Doctrine\UserRepository;
use App\Test\User\UserBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckUniqueNicknameTest extends KernelTestCase
{
    private $repository;
    private $interactor;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        self::bootKernel();
        $container = self::$container;

        $this->repository = $container->get(UserRepository::class);
        $this->interactor = $container->get(CheckUniqueNick::class);

        $userBuilder = new UserBuilder();
        $firstUser = $userBuilder
            ->withId($this->repository->nextId())
            ->withNick('nick')
            ->build();

        $this->repository->removeAll();
        $this->repository->save($firstUser);

        parent::__construct($name, $data, $dataName);
    }

    public function testUnique()
    {
        $this->assertTrue($this->interactor->execute("nick1222"));
        $this->assertFalse($this->interactor->execute("nick"));
        $this->assertFalse($this->interactor->execute("NICK"));
    }
}
