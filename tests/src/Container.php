<?php declare(strict_types = 1);

namespace App;

use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;

class Container
{

    private EntityManager $entityManager;

    private LoggerInterface $logger;

    public function __construct(EntityManager $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function getLogger(): LoggerInterface {
        return $this->logger;
    }

}
