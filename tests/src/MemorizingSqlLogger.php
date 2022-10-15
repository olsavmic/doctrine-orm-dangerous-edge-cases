<?php declare(strict_types = 1);

namespace App;

use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\LoggerInterface;

class MemorizingSqlLogger implements SQLLogger
{

    private array $queries;

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function startQuery($sql, ?array $params = null, ?array $types = null)
    {
        $this->queries[] = [
            'sql' => $sql,
            'params' => $params,
        ];

        $this->logger->debug('Executing query: {sql}', ['sql' => $sql, 'params' => $params]);
    }

    public function stopQuery()
    {
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

}
