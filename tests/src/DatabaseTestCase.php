<?php declare(strict_types = 1);

namespace App;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class DatabaseTestCase extends TestCase
{

    private static Container $container;

    protected function setUp(): void
    {
        parent::setUp();

        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->disableSqlLogging();
    }

    protected function getEntityManager(): EntityManager
    {
        return self::getContainer()->getEntityManager();
    }

    protected function enableSqlLogging(): void
    {
        $this->getEntityManager()
            ->getConfiguration()
            ->setSQLLogger(new MemorizingSqlLogger(self::$container->getLogger()));
    }

    protected function getSqlLogger(): MemorizingSqlLogger
    {
        $logger = $this->getEntityManager()
            ->getConfiguration()
            ->getSQLLogger();

        if (!$logger instanceof MemorizingSqlLogger) {
            throw new \LogicException('SQL logger is not enabled! Run $this->enableSqlLogging() first.');
        }

        return $logger;
    }

    protected function disableSqlLogging(): void
    {
        $this->getEntityManager()
            ->getConfiguration()
            ->setSQLLogger();
    }

    private static function getContainer(): Container
    {
        return self::$container;
    }

    public static function setContainer(Container $container): void
    {
        self::$container = $container;
    }

}
