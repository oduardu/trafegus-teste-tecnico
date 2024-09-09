<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = [__DIR__ . '/../../module/Application/src/Application/Model'];
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_pgsql',
    'user'     => 'trafegus',
    'password' => 'trafegus',
    'dbname'   => 'drivers',
];

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);