<?php

namespace App\Persistence\Repository\InMemory;


use App\Domain\Entity\User\User;
use App\Domain\Repository\NotFoundException;
use Ramsey\Uuid\Uuid;

class UserRepository implements \App\Domain\Repository\User\UserRepository
{
    private $users;

    public function __construct(array $users = [])
    {
        array_map(function (User $user) {
            $this->add($user);
        }, $users);
    }

    public function save(User $user): void
    {
        $this->add($user);
    }

    public function getById(string $id): User
    {
        $user = $this->findOneByExpression(function (User $user) use ($id) {
            return $user->getId() === $id;
        });

        if (!$user) {
            throw new NotFoundException('User not found!');
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneByExpression(function (User $user) use ($email) {
            return $user->getEmail() === $email;
        });
    }

    public function nextId(): string
    {
        return Uuid::uuid4()->toString();
    }

    private function add(User $user): void
    {
        $this->users[spl_object_hash($user)] = $user;
    }

    private function findOneByExpression($expression): ?User
    {
        $users = array_filter($this->users, $expression);

        if ($users) {
            return array_shift($users);
        }
        return null;
    }
}
