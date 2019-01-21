<?php


namespace App\Application\UseCase;


use App\Application\DTO\RegistrationDto;
use App\Domain\Entity\User\User;
use App\Domain\Factory\User\UserFactory;
use App\Domain\Repository\User\UserRepository;

class Registration
{
    private $userRepository;
    private $userFactory;

    public function __construct(UserRepository $userRepository, UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    public function execute(RegistrationDto $dto): User
    {
        $user = $this->userFactory->register(
            $dto->nick,
            $dto->firstName,
            $dto->lastName,
            $dto->email,
            $dto->password
        );
        $this->userRepository->save($user);
        return $user;
    }
}
