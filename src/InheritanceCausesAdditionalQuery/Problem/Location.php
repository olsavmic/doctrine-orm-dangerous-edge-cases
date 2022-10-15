<?php declare(strict_types = 1);

namespace App\InheritanceCausesAdditionalQuery\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;

#[Entity]
#[DiscriminatorMap([
    'pick_to_light' => PickToLightLocation::class,
    'narrow_aisle' => NarrowAisleLocation::class,
])]
#[DiscriminatorColumn(name: 'dtype', type: 'string')]
#[InheritanceType("JOINED")]
abstract class Location
{

    use EntityWithId;

}
