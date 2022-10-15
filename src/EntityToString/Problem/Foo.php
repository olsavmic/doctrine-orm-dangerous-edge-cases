<?php declare(strict_types = 1);

namespace App\EntityToString\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Stringable;

#[Entity]
class Foo implements Stringable
{

    use EntityWithId;

    public function __toString()
    {
        return EntityWithId::class . ' - ' . $this->getId();
    }

}
