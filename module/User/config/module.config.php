<?php

namespace User;

use User\Model\Factory\UserTableFactory;
use User\Model\UserTable;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'user' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/user',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action' => 'register',
                    ]
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'default' => [
                        'type' => Segment::class,
                        'options' => [
                            // exemplo -> meusite.com/user/confirm/token/md5
                            'route' => '[/:action][/token/:token]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'token' => '[[a-fA-F0-9]{32}]$'
                            ]
                        ]
                    ]
                ]

            ],
        ]
    ],
    'controllers' => [
        'factories' =>[
            Controller\IndexController::class => InvokableFactory::class
        ]
    ],
    'service_manager' =>[
        'factories' => [
            UserTable::class=> UserTableFactory::class
        ]
    ],
    'view_manager' => [
        'template_map' => [
            'user/layout/layout'               => __DIR__.'/../View/layout/layout.phtml',
            'user/index/regiter'               => __DIR__.'/../View/user/index/register.phtml',
            'user/index/confirmar-email'       => __DIR__.'/../View/user/index/confirmar-email.phtml',
            'user/index/new-password'          => __DIR__.'/../View/user/index/new-password.phtml',
            'user/index/recovered-password'    => __DIR__.'/../View/user/index/recovered-password.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../View',
        ]
    ]

];
