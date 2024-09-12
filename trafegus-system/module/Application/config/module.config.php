<?php

namespace Application;

use Zend\Mvc\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/[:controller[/:action]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => \Application\Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'vehicles' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vehicles[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => \Application\Controller\VehiclesController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'drivers' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/drivers[/:action[/:params]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'params' => '.*',
                    ],
                    'defaults' => [
                        'controller' => \Application\Controller\DriversController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'vinculos' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/vinculos[/:action[/:params]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'params' => '.*',
                    ],
                    'defaults' => [
                        'controller' => \Application\Controller\VinculosController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            \Application\Service\DriverService::class => \Application\Factory\DriverServiceFactory::class,
            \Application\Service\VehicleService::class => \Application\Factory\VehicleServiceFactory::class,
            \Application\Service\BondVehiclesAndDrivers::class => \Application\Factory\BondVehiclesAndDriversServiceFactory::class,
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            \Application\Controller\IndexController::class => function($container) {
                $parentLocator = $container->getServiceLocator();
                return new \Application\Controller\IndexController(
                    $parentLocator->get(\Doctrine\ORM\EntityManager::class)
                );
            },
            \Application\Controller\VehiclesController::class => function($container) {
                $parentLocator = $container->getServiceLocator();
                return new \Application\Controller\VehiclesController(
                    $parentLocator->get(\Doctrine\ORM\EntityManager::class)
                );
            },
            \Application\Controller\DriversController::class => function($container) {
                $parentLocator = $container->getServiceLocator();
                return new \Application\Controller\DriversController(
                    $parentLocator->get(\Doctrine\ORM\EntityManager::class)
                );
            },
            \Application\Controller\VinculosController::class => function($container) {
                $parentLocator = $container->getServiceLocator();
                return new \Application\Controller\VinculosController(
                    $parentLocator->get(\Doctrine\ORM\EntityManager::class)
                );
            },
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [],
        ],
    ],
    'doctrine' => array(
        'driver' => array(
            'pgsql' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . "/src/Application/Model"
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Model' => 'pgsql'
                )
            )
        )
    )
];