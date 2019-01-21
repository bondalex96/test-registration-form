<?php

namespace App\Domain\Specification\User;


use App\Domain\Entity\User\User;
use App\Domain\Repository\User\UserRepository;

class UniqueEmailSpecification
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isSatisfiedBy(string $email): bool
    {
        $user = $this->userRepository->findByEmail($email);
        return !($user instanceof User);
    }
}
