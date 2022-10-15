<?php declare(strict_types = 1);

namespace App\InheritanceCausesAdditionalQuery\Problem;

use App\DatabaseTestCase;

class OccurrenceTest extends DatabaseTestCase
{

    private const NUMBER_OF_ENTITIES_PER_TYPE = 1000;

    private function prepareData(): void
    {
        $em = $this->getEntityManager();

        for ($i = 0; $i < self::NUMBER_OF_ENTITIES_PER_TYPE; ++$i) {
            $location = new NarrowAisleLocation();
            $occurrence = new Occurrence($location);

            $em->persist($location);
            $em->persist($occurrence);
        }
    }

    public function testOccurrenceTriggersLocationLoad(): void
    {
        $this->prepareData();
        $em = $this->getEntityManager();

        $em->flush();
        $em->clear();

        $this->enableSqlLogging();

        $occurrences = $em->createQueryBuilder()
            ->select('o')
            ->from(Occurrence::class, 'o')
            ->getQuery()
            ->getResult();

        self::assertCount(self::NUMBER_OF_ENTITIES_PER_TYPE, $occurrences);
        self::assertCount(1, $this->getSqlLogger()->getQueries());
    }

}
