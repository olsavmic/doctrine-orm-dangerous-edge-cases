<?php declare(strict_types = 1);

namespace App\OrphanRemovalWithArrayCollection\Problem;

use App\EntityWithId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity]
class Container
{

    use EntityWithId;

    /**
     * @var Collection<int,Item>
     */
    #[OneToMany(mappedBy: 'container', targetEntity: Item::class, orphanRemoval: true)]
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

    public function removeAllItems(): void
    {
        $this->items->clear();
    }

    /**
     * @return ReadableCollection<int,Item>
     */
    public function getItems(): ReadableCollection
    {
        return $this->items;
    }

}
