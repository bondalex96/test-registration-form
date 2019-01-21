<?php

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationDto
{
    /**
     * @Assert\NotBlank
     */
    public $nick;

    /**
     * @Assert\NotBlank
     */
    public $firstName;

    /**
     * @Assert\NotBlank
     */
    public $lastName;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    public $email;

    /**
     * @Assert\NotBlank
     * @Assert\Length(min="5")
     */
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
