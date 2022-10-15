<?php declare(strict_types = 1);

namespace App\OrphanRemovalWithArrayCollection\Problem;

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

        $em->flush();
        $em->clear();

        $freshContainer = $em->find(Container::class, $container->getId());
        self::assertCount(0, $freshContainer->getItems());
    }

    public function testEntityDeletedAutomaticallyThanksToOrphanRemovalWithPersistentCollection(): void
    {
        $em = $this->getEntityManager();
        $container = new Container();
        $item = new Item($container);

        $em->persist($container);
        $em->persist($item);

        // This flush converts the ArrayCollection to PersistentCollection and since the persistent collection communicates with EntityManager,
        // it will be able to delete the item
        $em->flush();

        $container->removeAllItems();

        $em->flush();
        $em->clear();

        $freshContainer = $em->find(Container::class, $container->getId());
        self::assertCount(0, $freshContainer->getItems());
    }

}
