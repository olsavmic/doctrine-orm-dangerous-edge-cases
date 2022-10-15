<?php declare(strict_types = 1);

namespace App\InheritanceCausesAdditionalQuery\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Occurrence
{

    use EntityWithId;

    #[ManyToOne(targetEntity: Location::class)]
    #[JoinColumn]
    private Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

}
