<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\OneToManySolution;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Entity]
#[UniqueConstraint(name: 'UNIQ_PERSON', fields: ['person'])]
#[Table(name: 'personal_preference_one_to_many')]
class PersonalPreferences
{

    use EntityWithId;

    #[ManyToOne(targetEntity: Person::class, inversedBy: 'personalPreferences')]
    #[JoinColumn(nullable: false)]
    private Person $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
        $this->person->setPersonalPreferences($this);
    }

    public function getPerson(): Person
    {
        return $this->person;
    }

}
