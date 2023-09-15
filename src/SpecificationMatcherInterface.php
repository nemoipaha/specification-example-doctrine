<?php

declare(strict_types=1);

namespace Nemoi\SpecificationExampleDoctrine;

use Doctrine\Common\Collections\ArrayCollection;

interface SpecificationMatcherInterface
{
    public function matchSpecificationAsArray(QuerySpecificationInterface $specification): array;

    public function matchSpecificationAsCollectionResult(QuerySpecificationInterface $specification): ArrayCollection;

    public function matchSpecificationAsEntity(QuerySpecificationInterface $specification): ?object;

    public function matchSpecificationAsScalarResult(QuerySpecificationInterface $specification): mixed;
}
