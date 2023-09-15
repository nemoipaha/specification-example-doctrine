<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

final class PaginationSpecification extends AbstractQuerySpecification
{
    public function __construct(
        private readonly QuerySpecificationInterface $specification,
        private readonly int $limit = 100,
        private readonly int $offset = 0,
    ) {
    }

    public function applyOnQuery(Query $query): void
    {
        $this->specification->applyOnQuery($query);
    }

    public function applyOnQueryBuilder(QueryBuilder $queryBuilder): void
    {
        $this->specification->applyOnQueryBuilder($queryBuilder);
        $queryBuilder->setFirstResult($this->offset);
        $queryBuilder->setMaxResults($this->limit);
    }
}
