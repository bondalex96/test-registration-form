<?php

namespace App\Tests\Application\UseCase;

use App\Application\DTO\RegistrationDto;
use App\Application\UseCase\Registration;
use App\Domain\Entity\User\User;
use App\Persistence\Repository\Doctrine\UserRepository;
use App\Test\User\UserBuilder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RegistrationTest extends KernelTestCase
{
    private $repository;
    private $interactor;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        self::bootKernel();
        $container = self::$container;

        $this->repository = $container->get(UserRepository::class);
        $this->interactor = $container->get(Registration::class);

        $userBuilder = new UserBuilder();
        $firstUser = $userBuilder
            ->withId($this->repository->nextId())
            ->withEmail('some@email.com')
            ->build();

        $this->repository->removeAll();
        $this->repository->save($firstUser);

        parent::__construct($name, $data, $dataName);
    }

    public function testSuccessRegistration()
    {
        $dto = RegistrationDto::create(
            $nick = 'some90',
            $firstName = 'имя',
            $lastName = 'фамилия',
            $email = 'newemail@gmail.com',
            'password'
        );
        $user = $this->interactor->execute($dto);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($user->getNickName()->getNickname(), $nick);
        $this->assertEquals($user->getName()->getFirstName(), $firstName);
        $this->assertEquals($user->getName()->getLastName(), $lastName);
        $persistedUser = $this->repository->findByEmail($email);
        $this->assertEquals($user, $persistedUser);
    }

    public function testRegistrationWithExistingEmail()
    {
        $dto = RegistrationDto::create(
            'some90',
            'имя',
            'фамилия',
            $email = 'some@email.com',
            'password'
        );
        $this->expectExceptionObject(new \DomainException('User with email ' . $email . ' already exists!'));
        $this->interactor->execute($dto);
    }
}
