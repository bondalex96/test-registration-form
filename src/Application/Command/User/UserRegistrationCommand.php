<?php

namespace App\Application\Command\User;


use App\Infrastructure\CommandBus\Command;
use Symfony\Component\Validator\Constraints as Assert;


final class UserRegistrationCommand implements Command
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
     * @Assert\NotBlank(message="Фамилия обязательна для ввода!")
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


    public function __construct(
        string $nick,
        string $firstName,
        string $lastName,
        string $email,
        string $password)
    {
        $this->nick = $nick;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }
}
