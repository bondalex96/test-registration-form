<?php

namespace App\Application\Query\User;


use App\Application\ReadModels\SatisfactionOfCondition;
use App\Domain\Entity\User\NickName;
use App\Domain\Specification\User\UniqueNicknameSpecification;
use App\Infrastructure\QueryBus\Query;
use App\Infrastructure\QueryBus\QueryHandler;
use Webmozart\Assert\Assert;

class CheckUniqueNickHandler implements QueryHandler
{
    private $specification;

    public function __construct(UniqueNicknameSpecification $specification)
    {
        $this->specification = $specification;
    }

    public function handle(Query $query): object
    {
        /** @var CheckUniqueNickQuery $query */
        Assert::isInstanceOf($query, CheckUniqueNickQuery::class);

        $isSatisfiedBy = $this->specification->isSatisfiedBy(new NickName($query->nick));

        return new SatisfactionOfCondition($isSatisfiedBy);
    }

}
