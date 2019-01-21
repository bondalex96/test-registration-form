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
        $this->assertNotEmpty($nickName, 'Никнэйм не должен быть пустым!');
        $this->assertThatFirstCharacterIsLatin($nickName, 'Первый символ никнэйма может содержать только латинские символы!');
        $this->assertThatContainOnlyLatinCharactersAndDigits($nickName, 'Никнэйм может содержать только латинские символы и цифры!');
        $this->name = $nickName;
    }
}
