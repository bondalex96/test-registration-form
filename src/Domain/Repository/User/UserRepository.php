<?php

namespace App\Domain\Repository\User;


use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;

interface UserRepository
{
    public function getById(string $id): User;
    public function findByEmail(string $email): ?User;
    public function findByNick(NickName $nickName): ?User;
    public function save(User $user): void;
    public function nextId(): string;
}
