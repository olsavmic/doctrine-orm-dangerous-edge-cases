<?php declare(strict_types = 1);

namespace App\InheritanceCausesAdditionalQuery\Solution;

use App\DatabaseTestCase;
use App\InheritanceCausesAdditionalQuery\Problem\NarrowAisleLocation;
use App\InheritanceCausesAdditionalQuery\Problem\Occurrence;

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
            ->select('o, l')
            ->from(Occurrence::class, 'o')
            ->join('o.location', 'l')
            ->getQuery()
            ->getResult();

        self::assertCount(self::NUMBER_OF_ENTITIES_PER_TYPE, $occurrences);
        self::assertCount(1, $this->getSqlLogger()->getQueries());
    }

}
