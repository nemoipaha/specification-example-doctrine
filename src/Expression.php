<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Stringable;
use Doctrine\ORM\QueryBuilder;

interface Expression
{
    public function create(QueryBuilder $queryBuilder): Stringable;
}
