<?php

namespace App\Domain\Factory\User;


use App\Domain\Assert\AssertTrait;
use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserName;
use App\Domain\Repository\User\UserRepository;
use App\Domain\Services\PasswordEncryptor;
use App\Domain\Specification\User\UniqueEmailSpecification;
use App\Domain\Specification\User\UniqueNicknameSpecification;

class UserFactory
{
    use AssertTrait;
    private const PASSWORD_MIN_LENGTH = 5;

    private $userRepository;
    private $uniqueEmailSpecification;
    private $uniqueNicknameSpecification;
    private $passwordEncryptor;

    public function __construct(
        UniqueEmailSpecification $uniqueEmailSpecification,
        UniqueNicknameSpecification $uniqueNicknameSpecification,
        UserRepository $userRepository,
        PasswordEncryptor $passwordEncryptor
    ) {
        $this->userRepository = $userRepository;
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
        $this->uniqueNicknameSpecification = $uniqueNicknameSpecification;
        $this->passwordEncryptor = $passwordEncryptor;
    }

    public function register(string $nick, string $firstName, string $lastName, string $email, string $password): User
    {
        if (!$this->uniqueEmailSpecification->isSatisfiedBy($email)) {
            throw new \DomainException('Пользователь с  электронным адресом ' . $email . ' уже существует в системе!');
        }
        if (!$this->uniqueNicknameSpecification->isSatisfiedBy($nickName = new NickName($nick))) {
            throw new \DomainException('Пользователь с ником ' . $nick . ' уже существует в системе!');
        }

        $userId = $this->userRepository->nextId();

        $user = new User(
            $userId,
            $nickName,
            new UserName($firstName, $lastName),
            $email
        );

        $this->assertMinLength($password, self::PASSWORD_MIN_LENGTH, "Пароль не может содержать менее " . self::PASSWORD_MIN_LENGTH ." символов");
        $encryptedPassword = $this->passwordEncryptor->encrypt($password);
        $user->setPassword($encryptedPassword);

        return $user;
    }
}
