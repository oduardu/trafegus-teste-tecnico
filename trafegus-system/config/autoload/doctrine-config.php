<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Caminho para as entidades
$paths = [__DIR__ . '/src/Entity'];
$isDevMode = true;

//      POSTGRES_USER: trafegus
//      POSTGRES_PASSWORD: trafegus
//      POSTGRES_DB: drivers

// Configuração do banco de dados
$dbParams = [
    'driver'   => 'pdo_pgsql',
    'user'     => 'trafegus',
    'password' => 'trafegus',
    'dbname'   => 'drivers',
];

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);