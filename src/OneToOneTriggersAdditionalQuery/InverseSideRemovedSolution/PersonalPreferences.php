<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\InverseSideRemovedSolution;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Entity]
#[UniqueConstraint(name: 'UNIQ_PERSON', fields: ['person'])]
#[Table(name: 'personal_preference_inverse_side_removed')]
class PersonalPreferences
{

    use EntityWithId;

    #[ManyToOne(targetEntity: Person::class)]
    #[JoinColumn]
    private Person $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    public function getPerson(): Person
    {
        return $this->person;
    }

}
