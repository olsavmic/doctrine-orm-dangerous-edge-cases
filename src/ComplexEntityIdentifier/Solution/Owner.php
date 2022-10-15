<?php declare(strict_types = 1);

namespace App\ComplexEntityIdentifier\Solution;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'owner_solution')]
class Owner
{

    use EntityWithId;

    public function getId(): int
    {
        return $this->id;
    }

}
