<?php

namespace App\Domain\Entity\User;


use App\Domain\Assert\AssertTrait;

class User
{
    use AssertTrait;

    private $id;
    private $nickName;
    private $userName;
    private $email;
    private $password;

    public function __construct(string $id, NickName $nickName, UserName $userName, string $email)
    {
        $this->id = $id;
        $this->setNickName($nickName);
        $this->setUserName($userName);
        $this->setEmail($email);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNickName(): NickName
    {
        return $this->nickName;
    }

    public function getName(): UserName
    {
        return $this->userName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        if ($this->password) {
            throw new \DomainException('У пользователя уже установлен пароль!');
        }
        $this->password = $password;
    }

    // Private Methods

    private function setNickName(NickName $nickName): void
    {
        $this->nickName = $nickName;
    }

    private function setUserName(UserName $userName): void
    {
        $this->userName = $userName;
    }

    private function setEmail(string $email): void
    {
        $this->assertNotEmpty($email, 'Электронный адрес обязателен для ввода!');
        $this->assertEmail($email, 'Невалидный электронный адрес!');
        $this->email = $email;
    }
}
