<?php

namespace App\Domain\Repository\User;


use App\Domain\Entity\User\User;

interface UserRepository
{
    public function findByEmail(string $email): ?User;
    public function save(): void;
    public function nextId(): int;
}
