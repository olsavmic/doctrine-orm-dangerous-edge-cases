<?php declare(strict_types = 1);

namespace App\CollectionReassignment\Solution;

use App\DatabaseTestCase;

class ArticleTest extends DatabaseTestCase
{

    public function testCollectionReassignmentClearsPreviousData(): void
    {
        $em = $this->getEntityManager();

        $article = new Article('article');
        $tag1 = new Tag();
        $tag2 = new Tag();
        $article->setTags([$tag1]);

        $em->persist($article);
        $em->persist($tag1);
        $em->persist($tag2);

        // This flush is necessary since the issue is caused by missing information in the UnitOfWork change-set
        $em->flush();

        $article->setName('anotherName');
        $em->flush();

        $article->setTags([$tag2]);

        $em->flush();
        $em->clear();

        $freshArticle = $em->find(Article::class, $article->getId());
        self::assertCount(1, $freshArticle->getTags());
    }
}
