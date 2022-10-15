<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\OneToManySolution;

use App\EntityWithId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'person_one_to_many')]
class Person
{

    use EntityWithId;

    /**
     * @var Collection<PersonalPreferences>
     */
    #[OneToMany(mappedBy: 'person', targetEntity: PersonalPreferences::class)]
    private Collection $personalPreferences;

    public function __construct()
    {
        $this->personalPreferences = new ArrayCollection();
    }

    /**
     * @internal For bidirectional sync only
     */
    public function setPersonalPreferences(PersonalPreferences $personalPreferences): void
    {
        if (!$this->personalPreferences->isEmpty()) {
            throw new \LogicException('Personal preferences already set');
        }

        if ($personalPreferences->getPerson() !== $this) {
            throw new \LogicException("Personal preferences doesn't belong to this person");
        }

        $this->personalPreferences->clear();
        $this->personalPreferences->add($personalPreferences);
    }

    public function getPersonalPreferences(): ?PersonalPreferences
    {
        if ($this->personalPreferences->isEmpty()) {
            return null;
        }

        if ($this->personalPreferences->count() > 1) {
            throw new \LogicException("More than one personal preferences found!");
        }

        return $this->personalPreferences[0];
    }

}
