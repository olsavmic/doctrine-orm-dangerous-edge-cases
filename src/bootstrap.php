<?php declare(strict_types = 1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;

const DB_CONNECTION_CONFIG = [
    'driver' => 'pdo_mysql',
    'host' => 'mysql',
    'user' => 'root',
    'password' => 'secret',
    'dbname' => 'doctrine-edge-cases',
];

$ormConfiguration = ORMSetup::createAttributeMetadataConfiguration([__DIR__], true);
$ormConfiguration->setNamingStrategy(new UnderscoreNamingStrategy());

$entityManager = EntityManager::create(DB_CONNECTION_CONFIG, $ormConfiguration);

return $entityManager;
