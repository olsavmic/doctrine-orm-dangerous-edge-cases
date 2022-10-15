<?php declare(strict_types = 1);

namespace App\ComplexEntityIdentifier\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Property
{

    use EntityWithId;

    #[ManyToOne(targetEntity: Owner::class)]
    #[JoinColumn(nullable: false)]
    private Owner $owner;

    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    public function getOwner(): Owner
    {
        return $this->owner;
    }

}
