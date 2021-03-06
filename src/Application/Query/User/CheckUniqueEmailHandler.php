<?php

namespace App\Application\Query\User;


use App\Application\ReadModels\SatisfactionOfCondition;
use App\Domain\Specification\User\UniqueEmailSpecification;
use App\Infrastructure\QueryBus\Query;
use App\Infrastructure\QueryBus\QueryHandler;
use Webmozart\Assert\Assert;

class CheckUniqueEmailHandler implements QueryHandler
{
    private $specification;

    public function __construct(UniqueEmailSpecification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @param CheckUniqueEmailQuery $query
     * @return SatisfactionOfCondition
     */
    public function handle(Query $query): object
    {
        Assert::isInstanceOf($query, CheckUniqueEmailQuery::class);

        $isSatisfiedBy = $this->specification->isSatisfiedBy($query->email);

        return new SatisfactionOfCondition($isSatisfiedBy);
    }
}
