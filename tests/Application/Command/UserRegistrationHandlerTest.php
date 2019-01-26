<?php

namespace App\Tests\Application\UseCase;

use App\Application\Command\User\UserRegistrationCommand;
use App\Application\Command\User\UserRegistrationHandler;
use App\Domain\Entity\User\User;
use App\Persistence\Repository\Doctrine\UserRepository;
use App\Test\User\UserBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRegistrationHandlerTest extends KernelTestCase
{
    private $repository;
    /** @var UserRegistrationHandler */
    private $handler;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        self::bootKernel();
        $container = self::$container;

        $this->repository = $container->get(UserRepository::class);
        $this->handler = $container->get(UserRegistrationHandler::class);

        $userBuilder = new UserBuilder();
        $firstUser = $userBuilder
            ->withId($this->repository->nextId())
            ->withEmail('some@email.com')
            ->withNick('nick')
            ->build();

        $this->repository->removeAll();
        $this->repository->save($firstUser);

        parent::__construct($name, $data, $dataName);
    }

    public function testSuccessRegistration()
    {
        $command = new UserRegistrationCommand(
            $nick = 'some90',
            $firstName = 'имя',
            $lastName = 'фамилия',
            $email = 'newemail@gmail.com',
            'password'
        );
        $user = $this->handler->handle($command);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->getNickName()->getNickname(), $nick);
        $this->assertEquals($user->getName()->getFirstName(), $firstName);
        $this->assertEquals($user->getName()->getLastName(), $lastName);
        $persistedUser = $this->repository->findByEmail($email);
        $this->assertEquals($user, $persistedUser);
    }

    public function testRegistrationWithExistingEmail()
    {
        $command = new UserRegistrationCommand(
            'some91',
            'имя',
            'фамилия',
            $email = 'some@email.com',
            'password'
        );
        $this->expectExceptionObject(new \DomainException('Пользователь с  электронным адресом ' . $email . ' уже существует в системе!'));
        $this->handler->handle($command);
    }

    public function testRegistrationWithExistingNick()
    {
        $command = new UserRegistrationCommand(
            $nick = 'nick',
            'имя',
            'фамилия',
            $email = 'somee@email.com',
            'password'
        );
        $this->expectExceptionObject(new \DomainException('Пользователь с ником ' . $nick . ' уже существует в системе!'));
        $this->handler->handle($command);
    }
}
