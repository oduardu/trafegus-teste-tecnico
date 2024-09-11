<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Cache\ArrayCache;

$paths = [__DIR__ . '/../../module/Application/src/Application/Model'];
$isDevMode = true;

// Configuração do banco de dados
$dbParams = [
    'driver'   => 'pdo_pgsql',
    'user'     => 'trafegus',
    'password' => 'trafegus',
    'dbname'   => 'drivers',
    'host'     => 'localhost',
    'port'     => '5432',
];

// Configuração do cache
$cache = new ArrayCache();

// Configuração do Doctrine
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, $cache);

// Criação do EntityManager
$entityManager = EntityManager::create($dbParams, $config);

return $entityManager;
