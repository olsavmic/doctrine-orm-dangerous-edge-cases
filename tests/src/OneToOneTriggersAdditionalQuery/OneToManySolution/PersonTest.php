<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\OneToManySolution;

use App\DatabaseTestCase;

class PersonTest extends DatabaseTestCase
{

    private const NUMBER_OF_ENTITIES_PER_TYPE = 1000;

    private function prepareData(): void
    {
        $em = $this->getEntityManager();

        for ($i = 0; $i < self::NUMBER_OF_ENTITIES_PER_TYPE; ++$i) {
            $person = new Person();
            $personalPreferences = new PersonalPreferences($person);

            $em->persist($person);
            $em->persist($personalPreferences);
        }
    }

    public function testInverseSideTriggersOnlySingleQuery(): void
    {
        $this->prepareData();
        $em = $this->getEntityManager();

        $em->flush();
        $em->clear();

        $this->enableSqlLogging();

        $persons = $em->createQueryBuilder()
            ->select('p')
            ->from(Person::class, 'p')
            ->getQuery()
            ->getResult();

        self::assertCount(self::NUMBER_OF_ENTITIES_PER_TYPE, $persons);
        self::assertCount(1, $this->getSqlLogger()->getQueries());
    }

    /**
     * Loading owning side (in our case Person -> entity containing the #[JoinColumn]) triggers correctly only single query
     * when the other side of relationship is not needed
     */
    public function testOwningSideTriggersOnlySingleQuery(): void
    {
        $this->prepareData();
        $em = $this->getEntityManager();

        $em->flush();
        $em->clear();

        $this->enableSqlLogging();

        $preferences = $em->createQueryBuilder()
            ->select('pp')
            ->from(PersonalPreferences::class, 'pp')
            ->getQuery()
            ->getResult();

        self::assertCount(self::NUMBER_OF_ENTITIES_PER_TYPE, $preferences);
        self::assertCount(1, $this->getSqlLogger()->getQueries());
    }

    public function testExplicitJoinFetchWorks(): void
    {
        $this->prepareData();
        $em = $this->getEntityManager();

        $em->flush();
        $em->clear();

        $this->enableSqlLogging();

        $persons = $em->createQueryBuilder()
            ->select('p, pp')
            ->from(Person::class, 'p')
            ->leftJoin('p.personalPreferences', 'pp')
            ->getQuery()
            ->getResult();

        self::assertCount(self::NUMBER_OF_ENTITIES_PER_TYPE, $persons);
        self::assertCount(1, $this->getSqlLogger()->getQueries());
    }

}
