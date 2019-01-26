<?php

namespace App\Tests\Application\UseCase;

use App\Application\Query\User\CheckUniqueEmailHandler;
use App\Application\Query\User\CheckUniqueEmailQuery;
use App\Application\ReadModels\SatisfactionOfCondition;
use App\Persistence\Repository\Doctrine\UserRepository;
use App\Test\User\UserBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckUniqueEmailHandlerTest extends KernelTestCase
{
    private $repository;
    /** @var CheckUniqueEmailHandler */
    private $handler;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        self::bootKernel();
        $container = self::$container;

        $this->repository = $container->get(UserRepository::class);
        $this->handler = $container->get(CheckUniqueEmailHandler::class);

        parent::__construct($name, $data, $dataName);
    }

    public function setUp()
    {
        $userBuilder = new UserBuilder();
        $firstUser = $userBuilder
            ->withId($this->repository->nextId())
            ->withEmail('some@email.com')
            ->build();

        $this->repository->removeAll();
        $this->repository->save($firstUser);

        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function testUnique()
    {
        /** @var SatisfactionOfCondition $readModel */
        $readModel = $this->handler->handle(new CheckUniqueEmailQuery("some@email.com"));
        $this->assertInstanceOf(SatisfactionOfCondition::class, $readModel);
        $this->assertFalse($readModel->isSatisfiedBy());

        $readModel = $this->handler->handle(new CheckUniqueEmailQuery("somesome@email.com"));
        $this->assertInstanceOf(SatisfactionOfCondition::class, $readModel);
        $this->assertTrue($readModel->isSatisfiedBy());
    }
}
