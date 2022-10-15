<?php declare(strict_types = 1);

namespace App\PrivateMethodNotTriggeringProxyLoad\Problem;

use App\EntityWithId;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
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
            $result[] = $entity->text;
            $entity = $entity->parent;
        }

        return $result;
    }

}
