<?php

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegistrationDto
{
    /**
     * @Assert\NotBlank(message="Ник обязателен для ввода!")
     */
    public $nick;

    /**
     * @Assert\NotBlank(message="Имя обязательно для ввода!")
     */
    public $firstName;

    /**
     * @Assert\NotBlank(message="Фамилия обязательная для ввода!")
     */
    public $lastName;

    /**
     * @Assert\NotBlank(message="Электронная почта обязательна для ввода!")
     * @Assert\Email(message="Электронная почта невалидна!")
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Пароль обязателен для ввода!")
     * @Assert\Length(min="5", minMessage="Пароль не может быть короче пяти символов!")
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
