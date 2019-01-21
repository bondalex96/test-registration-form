<?php

namespace App\Domain\Assert;


class Assert extends \Webmozart\Assert\Assert
{
    protected static function reportInvalidArgument($message)
    {
        throw new \DomainException($message);
    }
}