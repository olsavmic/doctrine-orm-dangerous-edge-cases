<?php declare(strict_types = 1);

use App\DatabaseTestCase;
use App\TestContainer;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

const LOG_LEVEL = OutputInterface::VERBOSITY_DEBUG;

$entityManager = require dirname(__DIR__) . '/src/bootstrap.php';

$output = new ConsoleOutput(LOG_LEVEL);
$logger = new ConsoleLogger($output);

DatabaseTestCase::setContainer(new TestContainer($entityManager, $logger));
