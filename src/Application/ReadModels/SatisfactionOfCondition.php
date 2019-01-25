<?php

namespace App\Application\ReadModels;


class SatisfactionOfCondition
{
    private $isSatisfiedBy;

    public function __construct(bool $isSatisfiedBy)
    {
        $this->isSatisfiedBy = $isSatisfiedBy;
    }

    public function isSatisfiedBy(): bool
    {
        return $this->isSatisfiedBy;
    }
}
