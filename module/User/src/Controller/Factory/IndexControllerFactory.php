<?php


namespace User\Controller\Factory;


use Interop\Container\ContainerInterface;
use User\Controller\IndexController;
use User\Form\UserForm;
use User\Model\UserTable;
use Zend\Db\Adapter\Adapter;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
{

    /**
     * {@inheritDoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
     $adapter= $container->get(Adapter::class);

     $userForm = new UserForm($adapter);
     $userTable = $container->get(UserTable::class);
     return new IndexController($userForm, $userTable);

    }
}
