<?php

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationDto
{
    /**
     * @Assert\NotBlank(message="nick cannot be blank!")
     */
    public $nick;

    /**
     * @Assert\NotBlank(message="first name cannot be blank!")
     */
    public $firstName;

    /**
     * @Assert\NotBlank(message="last name cannot be blank!")
     */
    public $lastName;

    /**
     * @Assert\NotBlank(message="email cannot be blank!")
     * @Assert\Email(message="email is invalid!")
     */
    public $email;

    /**
     * @Assert\NotBlank(message="password cannot be blank!")
     * @Assert\Length(min="5", minMessage="password cannot be shorter than five characters")
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
