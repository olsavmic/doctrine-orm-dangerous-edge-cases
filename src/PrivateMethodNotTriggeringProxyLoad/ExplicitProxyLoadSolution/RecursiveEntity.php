<?php declare(strict_types = 1);

namespace App\PrivateMethodNotTriggeringProxyLoad\ExplicitProxyLoadSolution;

use App\EntityWithId;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Proxy\Proxy;

#[Entity]
#[Table(name: 'recursive_entity_explicit_proxy_load')]
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
            // Explicitly loading the proxy as loading is not triggered when calling private methods
            if ($entity instanceof Proxy && $entity->__isInitialized() === false) {
                $entity->__load();
            }

            $result[] = $entity->text;
            $entity = $entity->parent;
        }

        return $result;
    }

}
