<?php

namespace App\Application\DTO;


class RegistrationDto
{
    public $nick;
    public $firstName;
    public $lastName;
    public $email;
    public $password;

    public static function create(
        string $nick,
        string $firstName,
        string $lastName,
        string $email,
        string $password): self
    {
        $dto = new self();
        $dto->nick = $nick;
        $dto->firstName = $firstName;
        $dto->lastName = $lastName;
        $dto->email = $email;
        $dto->password = $password;

        return $dto;
    }
}
