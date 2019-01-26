<?php

namespace App\Tests\Application\UseCase;

use App\Application\Query\User\CheckUniqueNickHandler;
use App\Application\Query\User\CheckUniqueNickQuery;
use App\Application\ReadModels\SatisfactionOfCondition;
use App\Persistence\Repository\Doctrine\UserRepository;
use App\Test\User\UserBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckUniqueNicknameTest extends KernelTestCase
{
    private $repository;
    /** @var CheckUniqueNickHandler */
    private $handler;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        self::bootKernel();
        $container = self::$container;

        $this->repository = $container->get(UserRepository::class);
        $this->handler = $container->get(CheckUniqueNickHandler::class);


        parent::__construct($name, $data, $dataName);
    }

    public function setUp()
    {
        $userBuilder = new UserBuilder();
        $firstUser = $userBuilder
            ->withId($this->repository->nextId())
            ->withNick('nick')
            ->build();

        $this->repository->removeAll();
        $this->repository->save($firstUser);

        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testUnique()
    {
        /** @var SatisfactionOfCondition $readModel */
        $readModel = $this->handler->handle(new CheckUniqueNickQuery("nick1222"));
        $this->assertInstanceOf(SatisfactionOfCondition::class, $readModel);
        $this->assertTrue($readModel->isSatisfiedBy());

        $readModel = $this->handler->handle(new CheckUniqueNickQuery("nick"));
        $this->assertInstanceOf(SatisfactionOfCondition::class, $readModel);
        $this->assertFalse($readModel->isSatisfiedBy());

        $readModel = $this->handler->handle(new CheckUniqueNickQuery("nick"));
        $this->assertInstanceOf(SatisfactionOfCondition::class, $readModel);
        $this->assertFalse($readModel->isSatisfiedBy());
    }
}
