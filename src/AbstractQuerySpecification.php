<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use RuntimeException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\AbstractQuery;

use function count;
use function explode;
use function implode;
use function array_map;
use function array_shift;
use function str_contains;

abstract class AbstractQuerySpecification implements QuerySpecificationInterface
{
    public function applyOnQuery(Query $query): void
    {
        $query->setHydrationMode(AbstractQuery::HYDRATE_OBJECT);
    }

    /**
     * @throws RuntimeException
     */
    protected function getRootAlias(QueryBuilder $queryBuilder): string
    {
        $rootAliases = $queryBuilder->getRootAliases();

        if (count($rootAliases) === 0) {
            throw new RuntimeException();
        }

        return $rootAliases[0];
    }

    protected function getFieldName(QueryBuilder $queryBuilder, string $fieldName): string
    {
        return sprintf('%s.%s', $this->getRootAlias($queryBuilder), $fieldName);
    }

    protected function getFieldAlias(string $field): string
    {
        if (! str_contains($field, '.')) {
            return $field;
        }

        $parts = explode('.', $field);
        $start = array_shift($parts);

        return ':' . $start . implode('', array_map(ucfirst(...), $parts));
    }
}
