<?php declare(strict_types = 1);

namespace App\OneToOneTriggersAdditionalQuery\InverseSideRemovedSolution;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'person_inverse_side_removed')]
class Person
{

    use EntityWithId;

}
