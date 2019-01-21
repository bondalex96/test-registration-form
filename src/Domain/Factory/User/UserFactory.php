<?php

namespace App\Domain\Factory\User;


use App\Domain\Assert\AssertTrait;
use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserName;
use App\Domain\Repository\User\UserRepository;
use App\Domain\Specification\User\UniqueEmailSpecification;
use App\Domain\Specification\User\UniqueNicknameSpecification;

class UserFactory
{
    use AssertTrait;
    private const PASSWORD_MIN_LENGTH = 5;

    private $userRepository;
    private $uniqueEmailSpecification;
    private $uniqueNicknameSpecification;

    public function __construct(
        UniqueEmailSpecification $uniqueEmailSpecification,
        UniqueNicknameSpecification $uniqueNicknameSpecification,
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
        $this->uniqueNicknameSpecification = $uniqueNicknameSpecification;
    }

    public function register(string $nick, string $firstName, string $lastName, string $email, string $password): User
    {
        if (!$this->uniqueEmailSpecification->isSatisfiedBy($email)) {
            throw new \DomainException('User with email ' . $email . ' already exists!');
        }
        if (!$this->uniqueNicknameSpecification->isSatisfiedBy($nickName = new NickName($nick))) {
            throw new \DomainException('User with nick ' . $nick . ' already exists!');
        }

        $userId = $this->userRepository->nextId();

        $user = new User(
            $userId,
            $nickName,
            new UserName($firstName, $lastName),
            $email
        );

        $this->assertMinLength($password, self::PASSWORD_MIN_LENGTH, "Password shouldn't contain less than " . self::PASSWORD_MIN_LENGTH ." characters");
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $user->setPassword($passwordHash);

        return $user;
    }
}
