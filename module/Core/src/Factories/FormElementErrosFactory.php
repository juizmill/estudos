<?php


namespace Core\Factories;

use Zend\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;


class FormElementErrosFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function __invoke(\Interop\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        // TODO: Implement __invoke() method.

        $helper = new FormElementErros();

        $config = $container->get('config');
        if(isset($config['view_helper_config']['form_element_erross'])){
            $configHelper = $config['view_helper_config']['form_element_errors'];
            if (isset($configHelper['message_open_format'])){
                $helper->setMessageOpenFormat($configHelper['message_open_format']);
            }
            if (isset($configHelper['message_separator_string'])){
                $helper->setMessageSeparatortring($configHelper['message_separator_string']);
            }
            if (isset($configHelper['message_close_string'])){
                $helper->setMessageCloseString($configHelper['message_close_string']);
            }
        }
        return $helper;
    }
}
