<?php

namespace App\Test\User;


use App\Domain\Entity\User\NickName;
use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserName;

class UserBuilder
{
    private $id = 1;
    private $nick = 'nick94';
    private $firstName = 'имя';
    private $lastName = 'фамилия';
    private $email = 'email@gmail.com';

    public function withId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function withLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function withEmail(string $lastName): self
    {
        $this->email = $lastName;
        return $this;
    }

    public function withNick(string $nick): self
    {
        $this->nick = $nick;
        return $this;
    }

    public function build(): User
    {
        $user = new User(
            $this->id,
            new NickName($this->nick),
            new UserName($this->firstName, $this->lastName),
            $this->email
        );

        return $user;
    }
}
