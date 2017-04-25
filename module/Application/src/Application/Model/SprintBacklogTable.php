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
use Application\Model\SprintBacklog;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\Sql\Expression;

class SprintBacklogTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($codProjeto) {
        $select = new Select();
        $select->from(new TableIdentifier('sprint_backlog'))
                ->columns(array('cod_sprint_backlog', 'nome_sprint_backlog', 'descricao_sprint_backlog', 'tempo_sprint_backlog', 'cod_status', 'cod_participante','cod_projeto'))
                ->join('status', 'status.cod_status = sprint_backlog.cod_status', 'descricao_status')
                ->join('participante', 'participante.cod_participante = sprint_backlog.cod_participante', 'nome_participante')
                ->where('cod_projeto = ' . $codProjeto)
                ->order(array('sprint_backlog.cod_sprint_backlog'=>'DESC'));
        $linha = $this->tableGateway->selectWith($select);
//       echo $select->getSqlString();
        return $linha;
    }

    //metodo que retorna ultma sprint cadastrada
//    public function getLastId() {
//        $ultimoSprint = $this->tableGateway->lastInsertValue;
//        return $ultimoSprint;
//    }

    public function getSprintBacklog($codSprintBacklog) {
        $codSprintBacklog = (int) $codSprintBacklog;
        $rowset = $this->tableGateway->select(array('cod_sprint_backlog' => $codSprintBacklog));
        $row = $rowset->current();

        return $row;
    }

    public function salvar(SprintBacklog $sprintBacklog) {
        $data = array(
            'cod_sprint_backlog' => $sprintBacklog->codSprintBacklog,
            'nome_sprint_backlog' => $sprintBacklog->nomeSprintBacklog,
            'descricao_sprint_backlog' => $sprintBacklog->descricaoSprintBacklog,
            'tempo_sprint_backlog' => $sprintBacklog->tempoSprintBacklog,
            'cod_status' => $sprintBacklog->codStatus,
            'cod_projeto' => $sprintBacklog->codProjeto,
            'cod_participante' => $sprintBacklog->codParticipante,
            'cod_product_backlog' => $sprintBacklog->codProductBacklog,
        );

        try {
            $codSprintBacklog = $sprintBacklog->codSprintBacklog;
            if (!$this->getSprintBacklog($codSprintBacklog)) {
                $data['cod_sprint_backlog'] = $codSprintBacklog;
                return $this->tableGateway->insert($data);
            } else {
                return $this->tableGateway->update($data, array('cod_sprint_backlog' => $codSprintBacklog));
            }
        } catch (\Exception $e) {
            return $e->getPrevious()->getCode();
        }
    }

    public function excluir($codSprintBacklog) {
        return $this->tableGateway->delete(array('cod_sprint_backlog' => $codSprintBacklog));
    }
    
    public function retornarSprintBacklogEmAberto($codProjeto){
        $count = new Expression();
        $select = new Select();
        $select->from(new TableIdentifier('sprint_backlog'))
               ->columns(array('sprint_backlog_em_aberto'=> $count->setExpression("Count('cod_status')")))
               ->join('projeto','projeto.cod_projeto = sprint_backlog.cod_projeto',array())
               ->where('sprint_backlog.cod_projeto = '.$codProjeto.' and sprint_backlog.cod_status = 1');
                $linha = $this->tableGateway->selectWith($select);
                $rowset =$linha->current();
//       echo $select->getSqlString();
        return $rowset;
    }
    
    public function retornarSprintBacklogEmAndamento($codProjeto){
        $count = new Expression();
        $select = new Select();
        $select->from(new TableIdentifier('sprint_backlog'))
               ->columns(array('sprint_backlog_em_andamento'=> $count->setExpression("Count('cod_status')")))
               ->join('projeto','projeto.cod_projeto = sprint_backlog.cod_projeto',array())
               ->where('sprint_backlog.cod_projeto = '.$codProjeto.' and sprint_backlog.cod_status = 2');
                $linha = $this->tableGateway->selectWith($select);
                $rowset =$linha->current();
//       echo $select->getSqlString();
        return $rowset;
    }

    public function retornarSprintBacklogParado($codProjeto){
        $count = new Expression();
        $select = new Select();
        $select->from(new TableIdentifier('sprint_backlog'))
               ->columns(array('sprint_backlog_parado'=> $count->setExpression("Count('cod_status')")))
               ->join('projeto','projeto.cod_projeto = sprint_backlog.cod_projeto',array())
               ->where('sprint_backlog.cod_projeto = '.$codProjeto.' and sprint_backlog.cod_status = 3');
                $linha = $this->tableGateway->selectWith($select);
                $rowset =$linha->current();
//       echo $select->getSqlString();
        return $rowset;
    }

    public function retornarSprintBacklogFinalizado($codProjeto){
        $count = new Expression();
        $select = new Select();
        $select->from(new TableIdentifier('sprint_backlog'))
               ->columns(array('sprint_backlog_finalizado'=> $count->setExpression("Count('cod_status')")))
               ->join('projeto','projeto.cod_projeto = sprint_backlog.cod_projeto',array())
               ->where('sprint_backlog.cod_projeto = '.$codProjeto.' and sprint_backlog.cod_status = 4');
                $linha = $this->tableGateway->selectWith($select);
                $rowset =$linha->current();
//       echo $select->getSqlString();
        return $rowset;
    }
    
    public function retornarTotalSprintBacklog($codProjeto){
        $count = new Expression();
        $select = new Select();
        $select->from(new TableIdentifier('sprint_backlog'))
               ->columns(array('total_sprint_backlog'=> $count->setExpression("Count('cod_status')")))
               ->join('projeto','projeto.cod_projeto = sprint_backlog.cod_projeto',array())
               ->where('sprint_backlog.cod_projeto = '.$codProjeto);
                $linha = $this->tableGateway->selectWith($select);
                $rowset =$linha->current();
//       echo $select->getSqlString();
        return $rowset;
    }

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
