<?php declare(strict_types = 1);

namespace App\ComplexEntityIdentifier\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Owner
{

    use EntityWithId;

    public function getId(): int
    {
        if ($this->id === null) {
            throw new \LogicException('This should not happen');
        }

        return $this->id;
    }

}
