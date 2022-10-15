<?php declare(strict_types = 1);

namespace App\OrphanRemovalWithArrayCollection\NoOrphanRemovalSolution;

use App\EntityWithId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'container_no_orphan_removal')]
class Container
{

    use EntityWithId;

    /**
     * @var Collection<int,Item>
     */
    #[OneToMany(mappedBy: 'container', targetEntity: Item::class)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function addItem(Item $item): void
    {
        if ($item->getContainer() !== $this) {
            throw new \LogicException('Item is already assigned to another container');
        }

        $this->items->add($item);
    }

    /**
     * @return ReadableCollection<int,Item>
     */
    public function getItems(): ReadableCollection
    {
        return $this->items;
    }

    public function removeAllItems(): void
    {
        $this->items->clear();
    }

}
