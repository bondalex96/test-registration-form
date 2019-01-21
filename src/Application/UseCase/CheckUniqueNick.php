<?php


namespace App\Application\UseCase;

use App\Domain\Entity\User\NickName;
use App\Domain\Specification\User\UniqueNicknameSpecification;

class CheckUniqueNick implements Interactor
{
    private $specification;

    public function __construct(UniqueNicknameSpecification $specification)
    {
        $this->specification = $specification;
    }

    public function execute(string $nick): bool
    {
        return $this->specification->isSatisfiedBy(new NickName($nick));
    }
}
