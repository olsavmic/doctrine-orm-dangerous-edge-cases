<?php declare(strict_types = 1);

namespace App\PrivateMethodNotTriggeringProxyLoad\PublicMethodSolution;

use App\EntityWithId;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Proxy\Proxy;

#[Entity]
#[Table(name: 'recursive_entity_public_method')]
class RecursiveEntity
{

    use EntityWithId;

    #[JoinColumn(nullable: true)]
    #[ManyToOne(targetEntity: RecursiveEntity::class)]
    private ?RecursiveEntity $parent;

    #[Column(type: Types::STRING)]
    private string $text;

    public function __construct(string $text, ?RecursiveEntity $parent)
    {
        $this->text = $text;
        $this->parent = $parent;
    }

    public function getTextsRecursively(): array
    {
        $result = [];
        $entity = $this;
        while ($entity !== null) {
            // Only first call to public method would be sufficient but that would be a very unsafe solution
            // Access to all private properties/methods of another instance should be banned in case of this solution
            $result[] = $entity->getText();
            $entity = $entity->getParent();
        }

        return $result;
    }

    public function getParent(): ?RecursiveEntity
    {
        return $this->parent;
    }

    public function getText(): string
    {
        return $this->text;
    }

}
