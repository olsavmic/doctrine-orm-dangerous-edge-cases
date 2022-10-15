<?php declare(strict_types = 1);

namespace App\CollectionReassignment\Solution;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'tag_solution')]
class Tag
{

    use EntityWithId;
}
