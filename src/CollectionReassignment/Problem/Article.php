<?php declare(strict_types = 1);

namespace App\CollectionReassignment\Problem;

use App\EntityWithId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity]
class Article
{

    use EntityWithId;

    /**
     * @var Collection<int,Tag>
     */
    #[ManyToMany(targetEntity: Tag::class)]
    private Collection $tags;

    #[Column(type: Types::STRING)]
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->tags = new ArrayCollection();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param array<int,Tag> $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = new ArrayCollection($tags);
    }

    /**
     * @return ReadableCollection<int,Tag>
     */
    public function getTags(): ReadableCollection
    {
        return $this->tags;
    }

}
