<?php declare(strict_types = 1);

namespace App\OrphanRemovalWithArrayCollection\Problem;

use App\EntityWithId;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Item
{

    use EntityWithId;

    #[ManyToOne(targetEntity: Container::class, inversedBy: 'items')]
    #[JoinColumn(nullable: false)]
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->container->addItem($this);
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

}
