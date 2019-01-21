<?php

namespace App\Domain\Entity\User;


use App\Domain\Assert\AssertTrait;

class User
{
    use AssertTrait;

    private const PASSWORD_MIN_LENGTH = 5;
    private $id;
    private $nickName;
    private $userName;
    private $email;
    private $password;

    public static function register(int $id, NickName $nickName, UserName $userName, string $email, string  $password): User
    {
        $user = new self();
        $user->id = $id;
        $user->setNickName($nickName);
        $user->setUserName($userName);
        $user->setEmail($email);
        $user->setPassword($password);

        return $user;
    }

    public function getId()
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

    public function getPassword(): string
    {
        return $this->password;
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

    private function setPassword(string $password): void
    {
        $this->assertMinLength($password, self::PASSWORD_MIN_LENGTH, "Password shouldn't contain less than " . self::PASSWORD_MIN_LENGTH ." characters");
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    private function setEmail(string $email): void
    {
        $this->assertNotEmpty($email, 'Email can\'t be empty!');
        $this->assertEmail($email, 'Invalid email!');
        $this->email = $email;
    }
}
