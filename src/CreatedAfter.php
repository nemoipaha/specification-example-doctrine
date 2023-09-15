<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Stringable;
use DateTimeImmutable;
use Doctrine\ORM\QueryBuilder;

final class CreatedAfter extends AbstractQuerySpecification implements Expression
{
    private const CREATED_AT_FIELD_NAME = 'dateTime.createdAt';

    public function __construct(
        private readonly DateTimeImmutable $value,
        private readonly bool $greaterOrEqual = true,
    ) {
    }

    public function applyOnQueryBuilder(QueryBuilder $queryBuilder): void
    {
        $queryBuilder->andWhere($this->create($queryBuilder));
    }

    public function create(QueryBuilder $queryBuilder): Stringable
    {
        $comparison = $this->greaterOrEqual
            ? $queryBuilder->expr()->gte(
                $this->getFieldName($queryBuilder, self::CREATED_AT_FIELD_NAME),
                ':createdAt'
            )
            : $queryBuilder->expr()->gt(
                $this->getFieldName($queryBuilder, self::CREATED_AT_FIELD_NAME),
                ':createdAt'
            )
        ;

        $queryBuilder->setParameter('createdAt', $this->value->getTimestamp());

        return $comparison;
    }
}
