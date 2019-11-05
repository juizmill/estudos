<?php

use Zend\Db\Sql\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routers' => [
            'user'=>[
                'type'=>Literal::class,
                'options'=>[
                    'router' => '/user',
                    'defaults' => [
                        'controller' => \User\Controller\IndexController::class,
                        'action' => 'register'
                    ]
                ],
                'may_terminate' =>true,
                'child_routes' =>[
                    'default' => [
                        'type' =>Segment::class,
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
    'view_manager' =>[
        'template_map' =>[
            'user/index/regiter' => __DIR__.'/../View/user/index/confirmar-email.phtml',
            'user/index/new-password.phtml' => __DIR__.'/../View/user/index/new-password.phtml',
            'user/index/recovered-password.phtml' => __DIR__.'/../View/user/index/recovered-password.phtml',
            'user/index/register.phtml' => __DIR__.'/../View/user/index/register.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ]
    ]
];
