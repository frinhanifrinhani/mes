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
use Application\Model\ProductBacklogPorSprint;
use Application\Model\ProductBacklog;
use Zend\Db\Sql\TableIdentifier;

class ProductBacklogPorSprintTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($codProjeto) {
        $select = new Select();
        $select->from(new TableIdentifier('product_backlog'))
                ->columns(array('cod_product_backlog_pb' => 'cod_product_backlog', 'nome_product_backlog', 'cod_projeto'))
                ->join('product_backlog_para_sprint', 'product_backlog_para_sprint.cod_product_backlog = product_backlog.cod_product_backlog', array('cod_product_backlog','cod_sprint'), 'left')
                ->join('sprint', 'sprint.cod_sprint = product_backlog_para_sprint.cod_sprint','nome_sprint','left')
                ->where('product_backlog.cod_projeto = ' . $codProjeto)
                ->order(array('product_backlog.cod_product_backlog' => 'ASC'));
        $linha = $this->tableGateway->selectWith($select);
        return $linha;
    }

    public function getProductBackPorSprint($codProductBacklog) {
        $codProductBacklog = (int) $codProductBacklog;
        $rowset = $this->tableGateway->select(array('cod_product_backlog' => $codProductBacklog));
        $row = $rowset->current();
        return $row;
    }
    
    public function salvar(ProductBacklogPorSprint $productBacklogPorSprint) {
        $data = array(
            'cod_product_backlog' => $productBacklogPorSprint->codProductBacklog,
            'cod_sprint' => $productBacklogPorSprint->codSprint,
        );
        
        $numRegistro = count($data['cod_product_backlog']);
        $codSprint = $data['cod_sprint'];
        $codProductBacklog = $productBacklogPorSprint->codProductBacklog;
       
        $this->tableGateway->delete(array('cod_sprint' => $codSprint));
        
        for ($i = 0; $i < $numRegistro; $i++) {

            if (!$this->getProductBackPorSprint($codProductBacklog[$i])) {
                 $this->tableGateway->insert(array(
                    'cod_product_backlog' => $codProductBacklog[$i],
                    'cod_sprint' => $data['cod_sprint']));
            }
            
        }

    }

}
