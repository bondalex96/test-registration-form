<?php


namespace App\Application\UseCase;

use App\Domain\Specification\User\UniqueEmailSpecification;

class CheckUniqueEmail implements Interactor
{
    private $specification;

    public function __construct(UniqueEmailSpecification $specification)
    {
        $this->specification = $specification;
    }

    public function execute(string $email): bool
    {
        return $this->specification->isSatisfiedBy($email);
    }
}
