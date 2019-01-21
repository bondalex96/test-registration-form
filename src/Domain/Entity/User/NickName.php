<?php

namespace App\Domain\Entity\User;


use App\Domain\Assert\AssertTrait;

class NickName
{
    use AssertTrait;

    private $name;

    public function __construct(string $name)
    {
        $this->setNickName($name);
    }

    public function getNickname(): string
    {
        return $this->name;
    }

    public function isEqual(NickName $nickName) {
        return mb_strtolower($this->getNickname()) === mb_strtolower($nickName->getNickname());
    }

    // Private Methods

    private function setNickName(string $nickName): void
    {
        $this->assertNotEmpty($nickName, 'Nickname shouldn\'t be empty!');
        $this->assertThatFirstCharacterIsLatin($nickName, 'Nickname should starts from latin characters!');
        $this->assertThatContainOnlyLatinCharactersAndDigits($nickName, 'Nickname should contain only numbers and latin characters!');
        $this->name = $nickName;
    }
}
