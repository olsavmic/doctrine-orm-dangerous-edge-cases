<?php declare(strict_types = 1);

namespace App\CollectionReassignment\Solution;

use App\EntityWithId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'article_solution')]
class Article
{

    use EntityWithId;

    /**
     * @var Collection<int,Tag>
     */
    #[ManyToMany(targetEntity: Tag::class)]
    #[JoinTable(name: 'article_solution_tag_solution')]
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
        $this->tags->clear();
        foreach($tags as $tag) {
            $this->tags->add($tag);
        }
    }

    /**
     * @return ReadableCollection<int,Tag>
     */
    public function getTags(): ReadableCollection
    {
        return $this->tags;
    }

}
