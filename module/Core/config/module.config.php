<?php

use Core\Factories\TransportSmtFactory;
use Zend\Form\View\Helper\FormElementErrors;
use Core\Factories\FormElementErrosFactory;

return [
    'service_manager'=> [
        'factories'=> [
            'core.transport.smtp'=> TransportSmtFactory::class
        ]
    ],
    'view_helpers' => [
        'factories' =>[
            FormElementErrors::class=>FormElementErrosFactory::class
        ]
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [

            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],

    ],
];
