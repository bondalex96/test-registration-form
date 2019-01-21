<?php

namespace App\Domain\Entity\User;


use App\Domain\Assert\AssertTrait;

class UserName
{
    use AssertTrait;

    private $firstName;

    private $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    // Private Methods

    private function setFirstName(string $firstName): void
    {
        $this->assertNotEmpty($firstName,'Имя обязательно для ввода!');
        $this->assertThatContainOnlyRussianCharacters($firstName, 'Имя может содержать только русские символы!');
        $this->firstName = $firstName;
    }

    private function setLastName(string $lastName): void
    {
        $this->assertNotEmpty($lastName,'Фамилия обязательна для ввода!');
        $this->assertThatContainOnlyRussianCharacters($lastName, 'Фамилия может содержать только русские символы!');

        $this->lastName = $lastName;
    }
}
