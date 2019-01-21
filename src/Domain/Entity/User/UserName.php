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
        $this->assertNotEmpty($firstName,'First name shouldn\'t be empty!');
        $this->assertThatContainOnlyRussianCharacters($firstName, 'First name should have only Russian characters!');
        $this->firstName = $firstName;
    }

    private function setLastName(string $lastName): void
    {
        $this->assertNotEmpty($lastName,'Last name shouldn\'t be empty!');
        $this->assertThatContainOnlyRussianCharacters($lastName, 'Last name should have only Russian characters!');

        $this->lastName = $lastName;
    }
}
