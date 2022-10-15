<?php declare(strict_types = 1);

namespace App;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class DatabaseTestCase extends TestCase
{

    private static TestContainer $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->truncateDatabase();
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

    private static function getContainer(): TestContainer
    {
        return self::$container;
    }

    private function truncateDatabase(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS = 0;');

        $purger = new ORMPurger($this->getEntityManager());
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();

        $connection->executeStatement('SET FOREIGN_KEY_CHECKS = 1;');
    }

    /**
     * @internal Should be set once during PHPUnit bootstrap
     */
    public static function setContainer(TestContainer $container): void
    {
        self::$container = $container;
    }

}
