<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Entity]
#[UniqueConstraint(name: 'UNIQ_PERSON', fields: ['person'])]
class PersonalPreferences
{

    use EntityWithId;

    #[OneToOne(inversedBy: 'personalPreferences')]
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
