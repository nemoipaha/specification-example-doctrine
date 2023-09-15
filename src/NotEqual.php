<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Stringable;
use Doctrine\ORM\QueryBuilder;

final class NotEqual extends AbstractQuerySpecification implements Expression
{
    private readonly string $value;
    private readonly string $field;

    public function __construct(string $field, string $value)
    {
        $this->value = $value;
        $this->field = $field;
    }

    public function create(QueryBuilder $queryBuilder): Stringable
    {
        $fieldAlias = $this->getFieldAlias($this->field);
        $comparison = $queryBuilder->expr()->neq($this->getFieldName($queryBuilder, $this->field), $fieldAlias);
        $queryBuilder->setParameter($fieldAlias, $this->value);

        return $comparison;
    }

    public function applyOnQueryBuilder(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($this->create($queryBuilder));
    }
}
