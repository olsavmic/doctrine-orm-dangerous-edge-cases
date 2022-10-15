<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\InverseSideRemovedSolution;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class PersonalPreferencesRepository
{

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getByPerson(Person $person): ?PersonalPreferences
    {
        return $this->entityManager->createQueryBuilder()
            ->select('pp')
            ->from(PersonalPreferences::class, 'pp')
            ->andWhere('pp.person = :person')
            ->setParameter('person', $person)
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_OBJECT);
    }
}
