<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface QuerySpecificationInterface
{
    public function applyOnQuery(Query $query): void;

    public function applyOnQueryBuilder(QueryBuilder $queryBuilder): void;
}
