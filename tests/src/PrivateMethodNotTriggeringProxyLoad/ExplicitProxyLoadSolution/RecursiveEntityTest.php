<?php declare(strict_types = 1);

namespace App\PrivateMethodNotTriggeringProxyLoad\ExplicitProxyLoadSolution;

use App\DatabaseTestCase;

class RecursiveEntityTest extends DatabaseTestCase
{

    public function testGetTextsRecursively(): void
    {
        $em = $this->getEntityManager();

        $root = new RecursiveEntity('root', null);
        $child = new RecursiveEntity('child', $root);

        $em->persist($root);
        $em->persist($child);

        $em->flush();
        $em->clear();

        $freshChild = $em->find(RecursiveEntity::class, $child->getId());
        $this->assertSame(['child', 'root'], $freshChild->getTextsRecursively());
    }
}
