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
        $this->expectExceptionObject(new \DomainException('Никнэйм может содержать только латинские символы и цифры!'));
        new NickName($nick = 'Nickкнэйм');
    }

    public function testCreationWithoutFirstLatinCharacter()
    {
        $this->expectExceptionObject(new \DomainException('Первый символ никнэйма может содержать только латинские символы!'));
        new NickName($nick = '94nick');
    }

    public function testCreationEmpty()
    {
        $this->expectExceptionObject(new \DomainException('Никнэйм не должен быть пустым!'));
        new NickName($nick = '');
    }

    public function testEqual()
    {
        $first = new NickName('nick');
        $second = new NickName('Nick');
        $third = new NickName('nick1');
        $this->assertTrue($first->isEqual($second));
        $this->assertFalse($first->isEqual($third));
    }
}
