<?php declare(strict_types = 1);

namespace App\OrphanRemovalWithArrayCollection\NoOrphanRemovalSolution;

use App\DatabaseTestCase;

class ContainerTest extends DatabaseTestCase
{

    public function testEntityDeletedAutomaticallyThanksToOrphanRemoval(): void
    {
        $em = $this->getEntityManager();
        $container = new Container();
        $item = new Item($container);

        $em->persist($container);
        $em->persist($item);

        $container->removeAllItems();
        $em->remove($item);

        $em->flush();
        $em->clear();

        $freshContainer = $em->find(Container::class, $container->getId());
        self::assertCount(0, $freshContainer->getItems());
    }

}
