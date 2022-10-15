<?php declare(strict_types = 1);

namespace App\ComplexEntityIdentifier\Problem;

use App\DatabaseTestCase;

class OwnerTest extends DatabaseTestCase
{

    private function prepareOccurrence(): Property
    {
        $em = $this->getEntityManager();

        $location = new Owner();
        $occurrence = new Property($location);
        $em->persist($location);
        $em->persist($occurrence);

        return $occurrence;
    }

    public function testAccessingLocationIdShouldBeFreeOperation(): void
    {
        $em = $this->getEntityManager();

        $occurrence = $this->prepareOccurrence();
        $em->flush();

        $occurrenceId = $occurrence->getId();
        $em->clear();

        $this->enableSqlLogging();
        $freshProperty = $em->find(Property::class, $occurrenceId);
        self::assertCount(1, $this->getSqlLogger()->getQueries());

        $freshProperty->getOwner()->getId();
        self::assertCount(1, $this->getSqlLogger()->getQueries());
    }

}
