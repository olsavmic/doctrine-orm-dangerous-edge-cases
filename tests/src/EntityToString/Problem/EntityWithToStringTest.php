<?php declare(strict_types = 1);

namespace App\EntityToString\Problem;

use App\DatabaseTestCase;

class EntityWithToStringTest extends DatabaseTestCase
{

    public function testArrayUniqueWithNewlyCreatedEntities(): void
    {
        $entity1 = new Foo();
        $entity2 = new Foo();

        $listOfEntities = [$entity1, $entity2, $entity2];

        $uniqueList = array_unique($listOfEntities);
        self::assertCount(2, $uniqueList);
    }

    public function testArrayUniqueWithPersistedEntities(): void
    {
        $em = $this->getEntityManager();

        $entity1 = new Foo();
        $entity2 = new Foo();
        $em->persist($entity1);
        $em->persist($entity2);

        $em->flush();

        $listOfEntities = [$entity1, $entity2, $entity2];

        $uniqueList = array_unique($listOfEntities);
        self::assertCount(2, $uniqueList);
    }

}
