<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\InverseSideRemovedSolution;

use App\DatabaseTestCase;
use Doctrine\ORM\Query\Expr\Join;

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

        // This query is not equivalent to the other solutions
        // as it's not possible to hydrate `pp` on the Person entity as the relation is not defined there
        // You can still perform the same queries though by specifying the JOIN condition
        $persons = $em->createQueryBuilder()
            ->select('p')
            ->from(Person::class, 'p')
            ->leftJoin(
                PersonalPreferences::class,
                'pp',
                Join::WITH,
                'pp.person = p'
            )
            ->getQuery()
            ->getResult();

        self::assertCount(self::NUMBER_OF_ENTITIES_PER_TYPE, $persons);
        self::assertCount(1, $this->getSqlLogger()->getQueries());
    }

}
