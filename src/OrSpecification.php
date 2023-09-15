<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Doctrine\ORM\QueryBuilder;

final class OrSpecification extends AbstractQuerySpecification
{
    private readonly array $specs;

    public function __construct(Expression ...$specs)
    {
        $this->specs = $specs;
    }

    public function applyOnQueryBuilder(QueryBuilder $queryBuilder): void
    {
        $orX = $queryBuilder->expr()->orX();

        foreach ($this->specs as $spec) {
            $orX->add($spec->create($queryBuilder));
        }

        $queryBuilder->andWhere($orX);
    }
}
