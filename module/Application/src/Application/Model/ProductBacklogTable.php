<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Application\Model\ProductBacklog;
use Zend\Db\Sql\TableIdentifier;

class ProductBacklogTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($codProjeto) {
        $select = new Select();
        $select->from(new TableIdentifier('product_backlog'))
                ->columns(array('cod_product_backlog', 'nome_product_backlog','descricao_product_backlog','prioridade_product_backlog','cod_projeto','cod_status'))
                ->join('status', 'status.cod_status = product_backlog.cod_status', 'descricao_status')
                ->where('cod_projeto = ' . $codProjeto)
                ->order(array('cod_product_backlog' => 'desc'));
        $linha = $this->tableGateway->selectWith($select);
//       echo $select->getSqlString();  
        return $linha;
    }

//
//    public function getLastId() {
//        $ultimoSprint = $this->tableGateway->lastInsertValue;
//        return $ultimoSprint;
//    }
//
    public function getProductBacklog($codProductBacklog) {
        $codProductBacklog = (int) $codProductBacklog;
        $rowset = $this->tableGateway->select(array('cod_product_backlog' => $codProductBacklog));
        $row = $rowset->current();

        return $row;
    }

    public function salvar(ProductBacklog $productBacklog) {
        $data = array(
            'cod_product_backlog' => $productBacklog->codProductBacklog,
            'nome_product_backlog' => $productBacklog->nomeProductBacklog,
            'descricao_product_backlog' => $productBacklog->descricaoProductBacklog,
            'prioridade_product_backlog' => $productBacklog->prioridadeProductBacklog,
            'cod_projeto' => $productBacklog->codProjeto,
            'cod_status' => $productBacklog->codStatus,
        );

        try {
            $codProductBacklog = $productBacklog->codProductBacklog;
            if (!$this->getProductBacklog($codProductBacklog)) {
                $data['cod_product_backlog'] = $codProductBacklog;
                return $this->tableGateway->insert($data);
            } else {
                return $this->tableGateway->update($data, array('cod_product_backlog' => $codProductBacklog));
            }
        } catch (\Exception $e) {
            $e->getPrevious()->getMessage();
        }
    }

    public function excluir($codProductBacklog) {
        return $this->tableGateway->delete(array('cod_product_backlog' => $codProductBacklog));
    }
//
//    //metodo que retorna sql da tableGateway
//    public function getSql() {
//        return $this->tableGateway->getSql();
//    }
//
//    //metodo que retorna select da tableGateway
//    public function getSelect() {
//        $select = new Select($this->tableGateway->getTable());
//        return $select;
//    }

}
