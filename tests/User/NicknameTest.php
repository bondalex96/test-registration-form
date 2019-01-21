<?php

namespace App\Tests\User;

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
        $this->expectException(new \DomainException('Nickname should contain only numbers and latin characters!'));
        new NickName($nick = 'Nickкнэйм');
    }

    public function testCreationWithoutFirstLatinCharacter()
    {
        $this->expectException(new \DomainException('Nickname should start from latin characters!'));
        new NickName($nick = '94nick');
    }

    public function testCreationEmpty()
    {
        $this->expectException(new \DomainException('Nickname shouldn\'t be empty!'));
        new NickName($nick = '');
    }
}
