<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Doctrine\ORM\QueryBuilder;

final class AndSpecification extends AbstractQuerySpecification
{
    private readonly array $specs;

    public function __construct(Expression ...$specs)
    {
        $this->specs = $specs;
    }

    public function applyOnQueryBuilder(QueryBuilder $queryBuilder): void
    {
        $expressionBuilder = $queryBuilder->expr()->andX();

        foreach ($this->specs as $spec) {
            $expressionBuilder->add($spec->create($queryBuilder));
        }

        $queryBuilder->andWhere($expressionBuilder);
    }
}
