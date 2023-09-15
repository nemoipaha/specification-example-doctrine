<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class DefaultSpecificationMatcher implements SpecificationMatcherInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly string $entityClass,
        private readonly string $classAlias,
    ) {
    }

    private function createQueryBuilder(): QueryBuilder
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select($this->classAlias)
            ->from($this->entityClass, $this->classAlias)
        ;
    }

    public function matchSpecificationAsScalarResult(QuerySpecificationInterface $specification): mixed
    {
        $query = $this->applySpecification($specification);

        return $query->getSingleScalarResult();
    }

    public function matchSpecificationAsArray(QuerySpecificationInterface $specification): array
    {
        $query = $this->applySpecification($specification);

        return $query->getArrayResult();
    }

    public function matchSpecificationAsCollectionResult(QuerySpecificationInterface $specification): ArrayCollection
    {
        return new ArrayCollection((array) $this->applySpecification($specification)->getResult());
    }

    public function matchSpecificationAsEntity(QuerySpecificationInterface $specification): ?object
    {
        return $this->applySpecification($specification)->getOneOrNullResult();
    }

    private function applySpecification(QuerySpecificationInterface $specification): Query
    {
        $builder = $this->createQueryBuilder();
        $specification->applyOnQueryBuilder($builder);
        $query = $builder->getQuery();
        $specification->applyOnQuery($query);

        return $query;
    }
}
