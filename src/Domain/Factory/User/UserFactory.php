<?php

namespace App\Domain\Factory\User;


use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserName;
use App\Domain\Repository\User\UserRepository;
use App\Domain\Specification\User\UniqueEmailSpecification;

class UserFactory
{
    private $userRepository;
    private $uniqueEmailSpecification;

    public function __construct(UniqueEmailSpecification $uniqueEmailSpecification, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
    }

    public function register(string $nick, string $firstName, string $lastName, string $email, string $password): User
    {
        if (!$this->uniqueEmailSpecification->isSatisfiedBy($email)) {
            throw new \DomainException('User with email ' . $email . ' already exists!');
        }
        $userId = $this->userRepository->nextId();

        return User::register(
            $userId,
            new NickName($nick),
            new UserName($firstName, $lastName),
            $email,
            $password
        );
    }
}
