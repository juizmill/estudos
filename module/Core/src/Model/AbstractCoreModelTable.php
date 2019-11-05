<?php


namespace Core\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

abstract class AbstractCoreModelTable
{
    protected  $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public  function getBy(array $params)
    {
        $rowset = $this->tableGateway->select($params);
        $row = $rowset->current();
        if(!$row){
            throw new \http\Exception\RuntimeException('Could not find row');
        }
        return $row;
    }

    public function save(array $date)
    {
        if (isset($date['id'])){
            $id = (int) $date['id'];

            if(! $this->getBy(['id'])){
                throw new \http\Exception\RuntimeException(sprintf(
                    'Nao foi possivel encontrar o id !', $id
                ));
            }

            $this->tableGateway->update($date, ['id' => $id]);

            return $this->getBy(['id' => $id]);

        }

        $this->tableGateway->insert($date);

        return $this->getBy(['id' => $this->tableGateway->getLastInsertValue()]);

    }

    public function delete($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

}
