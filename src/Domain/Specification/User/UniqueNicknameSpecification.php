<?php

namespace App\Domain\Specification\User;


use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Repository\User\UserRepository;

class UniqueNicknameSpecification
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function isSatisfiedBy(NickName $nickName): bool
    {
        $user = $this->userRepository->findByNick($nickName);
        return !($user instanceof User);
    }
}
