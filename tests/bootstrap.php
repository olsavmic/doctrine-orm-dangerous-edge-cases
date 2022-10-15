<?php declare(strict_types = 1);

use App\Container;
use App\DatabaseTestCase;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\ConsoleOutput;

const LOG_LEVEL = ConsoleOutput::VERBOSITY_DEBUG;

$output = new ConsoleOutput(LOG_LEVEL);
$logger = new ConsoleLogger($output);

$entityManager = require dirname(__DIR__) . '/src/bootstrap.php';

DatabaseTestCase::setContainer(new Container($entityManager, $logger));
