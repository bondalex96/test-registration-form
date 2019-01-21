<?php

namespace App\Tests\Domain\Entity\User;

use App\Domain\Entity\User\NickName;
use PHPUnit\Framework\TestCase;

class NicknameTest extends TestCase
{
    public function testSuccess()
    {
        $nickname = new NickName($nick = 'nick94');
        $this->assertEquals($nick, $nickname->getNickname());
    }

    public function testCreationWithRussianCharacters()
    {
        $this->expectExceptionObject(new \DomainException('Nickname should contain only numbers and latin characters!'));
        new NickName($nick = 'Nickкнэйм');
    }

    public function testCreationWithoutFirstLatinCharacter()
    {
        $this->expectExceptionObject(new \DomainException('Nickname should starts from latin characters!'));
        new NickName($nick = '94nick');
    }

    public function testCreationEmpty()
    {
        $this->expectExceptionObject(new \DomainException('Nickname shouldn\'t be empty!'));
        new NickName($nick = '');
    }
}
