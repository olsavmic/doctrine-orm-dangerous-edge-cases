<?php declare(strict_types = 1);

namespace App\EntityToString\Solution;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'foo_solution')]
class Foo
{

    use EntityWithId;

}
