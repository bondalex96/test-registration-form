<?php

namespace App\Domain\Assert;


trait AssertTrait
{
    protected function assertThatContainOnlyLatinCharactersAndDigits($value, $message): void
    {
        Assert::regex($value, Regex::ONLY_LATIN_CHARACTERS_AND_DIGITS, $message);
    }

    protected function assertThatFirstCharacterIsLatin($value, $message): void
    {
        $first = substr($value, 0, 1);
        Assert::regex($first, Regex::ONLY_LATIN_CHARACTERS, $message);
    }

    protected function assertNotEmpty($value, $message): void
    {
        Assert::notEmpty($value, $message);
    }

    protected function assertThatContainOnlyRussianCharacters($value, $message): void
    {
        Assert::regex($value, Regex::ONLY_RUSSIAN_CHARACTERS, $message);
    }

    protected function assertEmail($value, $message): void
    {
        Assert::regex($value, Regex::EMAIL, $message);
    }

    protected function assertMinLength($value, $minLength, $message): void
    {
        Assert::minLength($value, $minLength, $message);
    }
}
