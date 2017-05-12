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
use Zend\Db\Sql\Expression;

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
                ->where('cod_projeto = ' .$codProjeto)
                ->order(array('product_backlog.cod_product_backlog'=>'ASC'));
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
    
    public function retornarDadosProductBacklog($codProjeto){
        $expression = new Expression();

        $select = new Select();
        $select->from('product_backlog');

        $productBacklogEmAberto = new Select();
        $productBacklogEmAberto->from('product_backlog')
                ->columns(array('product_backlog_em_aberto' => $expression->setExpression("COUNT('cod_status')")))
                ->where("product_backlog.cod_projeto = {$codProjeto} AND product_backlog.cod_status = 1");

        $productBacklogEmAndamento = new Select();
        $productBacklogEmAndamento->from('product_backlog')
                ->columns(array('product_backlog_em_andamento' => $expression->setExpression("COUNT('cod_status')")))
                ->where("product_backlog.cod_projeto = {$codProjeto} AND product_backlog.cod_status = 2");

        $productBacklogParado = new Select();
        $productBacklogParado->from('product_backlog')
                ->columns(array('product_backlog_parado' => $expression->setExpression("COUNT('cod_status')")))
                ->where("product_backlog.cod_projeto = {$codProjeto} AND product_backlog.cod_status = 3");

        $productBacklogFinalizado = new Select();
        $productBacklogFinalizado->from('product_backlog')
                ->columns(array('product_backlog_finalizado' => $expression->setExpression("COUNT('cod_status')")))
                ->where("product_backlog.cod_projeto = {$codProjeto} AND product_backlog.cod_status = 4");

        $totalProdcutBacklog = new Select();
        $totalProdcutBacklog->from('product_backlog')
                ->columns(array('total_product_backlog' => $expression->setExpression("COUNT('prioridade_product_backlog')")))
                ->where("product_backlog.cod_projeto = {$codProjeto}");
                
        $productBacklogPrioridadeAlta = new Select();
        $productBacklogPrioridadeAlta->from('product_backlog')
                ->columns(array('product_backlog_prioridade_alta' => $expression->setExpression("COUNT('cod_status')")))
                ->where("product_backlog.cod_projeto = {$codProjeto} AND product_backlog.prioridade_product_backlog = 1");
                
        $productBacklogPrioridadeMedia = new Select();
        $productBacklogPrioridadeMedia->from('product_backlog')
                ->columns(array('product_backlog_prioridade_media' => $expression->setExpression("COUNT('cod_status')")))
                ->where("product_backlog.cod_projeto = {$codProjeto} AND product_backlog.prioridade_product_backlog = 2");
                
        $productBacklogPrioridadeBaixa = new Select();
        $productBacklogPrioridadeBaixa->from('product_backlog')
                ->columns(array('product_backlog_prioridade_baixa' => $expression->setExpression("COUNT('cod_status')")))
                ->where("product_backlog.cod_projeto = {$codProjeto} AND product_backlog.prioridade_product_backlog = 3");

        $select->columns(array(
                    'product_backlog_em_aberto' => new \Zend\Db\Sql\Expression('?', array($productBacklogEmAberto)),
                    'product_backlog_em_andamento' => new \Zend\Db\Sql\Expression('?', array($productBacklogEmAndamento)),
                    'product_backlog_parado' => new \Zend\Db\Sql\Expression('?', array($productBacklogParado)),
                    'product_backlog_finalizado' => new \Zend\Db\Sql\Expression('?', array($productBacklogFinalizado)),
                    'total_product_backlog' => new \Zend\Db\Sql\Expression('?', array($totalProdcutBacklog)),
                    'product_backlog_prioridade_alta' => new \Zend\Db\Sql\Expression('?', array($productBacklogPrioridadeAlta)),
                    'product_backlog_prioridade_media' => new \Zend\Db\Sql\Expression('?', array($productBacklogPrioridadeMedia)),
                    'product_backlog_prioridade_baixa' => new \Zend\Db\Sql\Expression('?', array($productBacklogPrioridadeBaixa)),
                ))
                ->join('projeto', 'projeto.cod_projeto = product_backlog.cod_projeto', array())
                ->group(array(
                    'product_backlog_em_aberto',
                    'product_backlog_em_andamento',
                    'product_backlog_parado',
                    'product_backlog_finalizado',
                    'total_product_backlog',
                    'product_backlog_prioridade_alta',
                    'product_backlog_prioridade_media',
                    'product_backlog_prioridade_baixa',
                    )
        );

        $linha = $this->tableGateway->selectWith($select);
//        echo $select->getSqlString();
        $rowset = $linha->current();
        return $rowset;

    }
    
    public function countProductBacklog(){
        $expression = new Expression();

        $select = new Select();
        $select->from('product_backlog');

        $totalProductBacklog = new Select();
        $totalProductBacklog->from('product_backlog')
                ->columns(array('total_product_backlog' => $expression->setExpression("COUNT('cod_prodcut_backlog')")));

        $productBacklogFinalizado = new Select();
        $productBacklogFinalizado->from('product_backlog')
                ->columns(array('product_backlog_finalizado' => $expression->setExpression("COUNT(cod_status)")))
                ->where("cod_status = 4");

        $select->columns(array(
                    'total_product_backlog' => new \Zend\Db\Sql\Expression('?', array($totalProductBacklog)),
                    'product_backlog_finalizado' => new \Zend\Db\Sql\Expression('?', array($productBacklogFinalizado)),
                ))
                ->group(array(
                    'total_product_backlog',
                    'product_backlog_finalizado')
        );

        $linha = $this->tableGateway->selectWith($select);
//        echo $select->getSqlString();  
        $rowset = $linha->current();
        return $rowset;
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
