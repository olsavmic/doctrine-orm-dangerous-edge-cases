<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToOne;

#[Entity]
class Person
{

    use EntityWithId;

    #[OneToOne(mappedBy: 'person')]
    private ?PersonalPreferences $personalPreferences = null;

    /**
     * @internal For bidirectional sync only
     */
    public function setPersonalPreferences(PersonalPreferences $personalPreferences): void
    {
        if ($this->personalPreferences !== null) {
            throw new \LogicException('Personal preferences already set');
        }

        if ($personalPreferences->getPerson() !== $this) {
            throw new \LogicException("Personal preferences doesn't belong to this person");
        }

        $this->personalPreferences = $personalPreferences;
    }

    public function getPersonalPreferences(): ?PersonalPreferences
    {
        return $this->personalPreferences;
    }

}
