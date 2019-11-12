<?php


namespace User\Model\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use User\Model\User;
use User\Model\UserTable;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserTableFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
       $adapter = $container->get(Adapter::class);
       $resultSetPrototype = new ResultSet();
       $resultSetPrototype->setArrayObjectPrototype(new User());

       $tableGateway = new TableGateway('user', $adapter, null, $resultSetPrototype);

       return new  UserTable($tableGateway);
    }
}
